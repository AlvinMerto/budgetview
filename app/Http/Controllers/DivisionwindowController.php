<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\budgetview;
use App\Models\loginControl;
use App\Models\chargingto;
use App\Models\chargingtbl;
use App\Models\inputwindow;

use Auth;
use DB;

class DivisionwindowController extends Controller
{
    //
    function divisionwindow($chargingid = null, $tab = null, $divisionid = null) {

        $id              = Auth::id();
                            // select("chargingtbls.chargingid")
        $division        = loginControl::join("divisiontbls","login_controls.divisionid","=","divisiontbls.divisionid")
                            ->where("login_controls.userid",$id)
                            ->get(["divisiontbls.divisionid","divisiontbls.divfullname"])->toArray(); 

        $budgetlines     = loginControl::join("chargingtbls","login_controls.divisionid","=","chargingtbls.divisionid")
                            ->join("budgetviews","chargingtbls.chargingid","=","budgetviews.divid")
                            ->where(["login_controls.userid"=>$id,"budgetviews.isactive"=>1])
                            ->get(); 
                            
        $inactivebudgetlines     = loginControl::join("chargingtbls","login_controls.divisionid","=","chargingtbls.divisionid")
                                    ->join("budgetviews","chargingtbls.chargingid","=","budgetviews.divid")
                                    ->where(["login_controls.userid"=>$id,"budgetviews.isactive"=>0])
                                    ->get();   

        $chargingids      = [];
        $budget           = [];
        $budgetlinestatus = [];

        if ($chargingid != null) {
            $budgetlinestatus = budgetview::where("divid",$chargingid)->get("isactive");
        }

        // $budget          = budgetview::join("chargingtbls","budgetviews.divid","=","chargingtbls.chargingid")
        //                     ->whereIn("divid",$chargingids)
        //                     ->get(["budgetviews.*","chargingtbls.chargingname"]);

        $information     = [];
        $year            = null;
        $selecteddiv     = null;
        $spent           = 0;
        $planned         = 0;
        $actual          = 0;
        $leftospend      = 0;

        // activities 
        $activities      = [];

        // charges
        $charges         = [];

        // per division 
        $divisionbudget  = [];

        $displayright    = false;
        if ($chargingid != null) {
            $selecteddiv = $this->getdivision($chargingid);
            if ($tab != null) {
                switch ($tab) {
                    case 'division':
                        $displayright     = "division";

                        $divisionbudget   = $this->getdivisionbudget($selecteddiv);
                        $divisionexpenses = $this->getdivisionexpenditure($selecteddiv);

                        $planned          = $divisionbudget['planned'];
                        $actual           = $divisionbudget['actual'];
                        $spent            = $divisionexpenses['totalspent'];
                        $leftospend       = $actual-$spent;
                        
                        break;
                    case 'information':
                        $displayright = "information";

                        $budgetdet  = $this->getbudgetarydetails($chargingid);

                        $spent      = $this->getexpenditure($chargingid)['totalspent'];

                        //if (count($budget) > 0) {
                            $planned    = $budgetdet['planned'];
                            $actual     = $budgetdet['actual'];
                            $leftospend = $actual-$spent;
                            $year       = $budgetdet['year'];
                        //}
                        break;
                    case 'activities':
                        $displayright = "activities";
                        $activities   = $this->getactivities($chargingid,$selecteddiv);

                        break;
                    case 'charging':
                        $displayright = "charging";
                        $charges      = $this->getcharges($chargingid);

                        break;
                    case 'projects':
                        $displayright = "projects";
                        $charges      = $this->getcharges($chargingid);
                        
                        break;
                    default:
                        die("Do not know what you are looking for");
                        break;
                }
            }
            
        }

        $qtr         = null;
        $bur         = null;

        if ($tab == "information") {
            $bur         = ($spent/$actual)*100;
            $bur         = number_format($bur,2);

            $date        = date("l, M. d, Y");
            $date_month  = date("m");
            
            
            if ($date_month >= 1 && $date_month <= 3) {
                $qtr     = "1st Quarter of ".date("Y");
            } else if ($date_month >= 4 && $date_month <= 6) {
                $qtr     = "2st Quarter of".date("Y");
            } else if ($date_month >= 7 && $date_month <= 9) {
                $qtr     = "3rd Quarter of".date("Y");
            } else if ($date_month >= 10 && $date_month <= 12) {
                $qtr     = "4th Quarter of".date("Y");
            }
        }

        return view("divisionwindow", 
                        compact("budget","division","budgetlines", "displayright","tab", 
                                "chargingid","spent","planned","actual","leftospend","year","selecteddiv",
                                "activities","charges","inactivebudgetlines","budgetlinestatus","divisionid","bur","qtr"));
    }

    function getdivisionexpenditure($division_id) {
        $charges = chargingto::join("chargingtbls","chargingtos.chargeto","=","chargingtbls.chargingid")
                                ->join("inputwindows","chargingtos.activitygrpid","=","inputwindows.activitygrpid")
                                ->where(["chargingtbls.divisionid"=>$division_id,"inputwindows.status"=>"100"])
                                ->get(["chargingtos.actualcost"]);

        $totalspent = 0;
     
        foreach($charges as $c) {
            $totalspent = $totalspent+$c->actualcost;
        }

        // if (count($charges) > 0) {
            return [
                "totalspent"   => $totalspent,
            ];

        return $division_expenses;
    }

    function getdivisionbudget($division_id) {
        $divisionbudget    = DB::select("select sum(planned) as planned, sum(actual) as actual from budgetviews join chargingtbls on budgetviews.divid = chargingtbls.chargingid where chargingtbls.divisionid = '{$division_id}' and budgetviews.isactive = 1; ");

        $planned = 0;
        $actual  = 0;

        if ( count($divisionbudget) > 0 ) {
            $planned = $divisionbudget[0]->planned;
            $actual  = $divisionbudget[0]->actual;
        }

        return [
            "planned"   => $planned,
            "actual"    => $actual
        ];
    }

    function getactivities($chargingid, $divisionid = null) {
        $collection    = inputwindow::join("chargingtos","inputwindows.activitygrpid","=","chargingtos.activitygrpid")
                                    ->where(["chargingtos.chargeto"=>$chargingid,"inputwindows.division"=>$divisionid])
                                    ->groupBy("inputwindows.activitygrpid")
                                    ->get();

        return $collection;
    }

    function getcharges($chargingid) {
        $collection = chargingto::join("inputwindows","inputwindows.activitygrpid","=","chargingtos.activitygrpid")
                                ->join("divisiontbls","inputwindows.division","=","divisiontbls.divisionid")
                                ->join("chargetypes","chargingtos.chargewhat","=","chargetypes.chargetypeid")
                                ->where("chargingtos.chargeto",$chargingid)
                                ->get(["divfullname","chargename","chargingtos.actualcost"]);
        return $collection;
    }

    function getdivision($chargingid) {
        $division = chargingtbl::where("chargingid",$chargingid)->get("divisionid");

        if (count($division) > 0) {
            return $division[0]->divisionid; 
        }
        return false;
    }

    function getdivision_graph(Request $req) {
        $selecteddiv      = $req->input("chargingid");

        $divisionbudget   = $this->getdivisionbudget($selecteddiv);
        $divisionexpenses = $this->getdivisionexpenditure($selecteddiv);

        $planned          = $divisionbudget['planned'];
        $actual           = $divisionbudget['actual'];
        $spent            = $divisionexpenses['totalspent'];
        $leftospend       = $actual-$spent;

        return response()->json([
            //$planned,
            $actual,
            $spent,
            $leftospend
        ]);
    }

    function getbudgetutilization_graph(Request $req) {
        $chargingid = $req->input("chargingid");

        $budget     = $this->getbudgetarydetails($chargingid);

        $spent      = $this->getexpenditure($chargingid)['totalspent'];
        $planned    = $budget['planned'];
        $actual     = $budget['actual'];
        $leftospend = $actual-$spent;

        return response()->json([
            $planned,
            $actual,
            $spent,
            $leftospend
        ]);
    }

    function getbudgetarydetails($chargeid) {
        $budget  = budgetview::where(["divid"=>$chargeid])->get(); // ,"isactive"=>1

        $planned = 0;
        $actual  = 0;
        $year    = 0;

        if (count($budget) > 0) {
            $planned = $budget[0]->planned;
            $actual  = $budget[0]->actual;
            $year    = $budget[0]->year;
        }

            return [
                "planned"    => $planned,
                "actual"     => $actual,
                "year"       => $year
            ];
    }

    function getexpenditure($chargeid) {
        $charges = chargingto::join("chargingtbls","chargingtos.chargeto","=","chargingtbls.chargingid")
                                ->join("inputwindows","chargingtos.activitygrpid","=","inputwindows.activitygrpid")
                                ->where(["chargingtbls.chargingid"=>$chargeid,"inputwindows.status"=>"100"])
                                ->get(["chargingtos.actualcost"]);

        $totalspent = 0;
     
        foreach($charges as $c) {
            $totalspent = $totalspent+$c->actualcost;
        }

        // if (count($charges) > 0) {
            return [
                "totalspent"   => $totalspent,
            ];
    }

    function postbudgetentry(Request $req) {
        $budgetname      = $req->input("budgetname");
        $plannedamount   = $req->input("plannedamount");
        $actualamount    = $req->input('actualamount');
        $budgetyear      = $req->input("budgetyear");
        $divisionid      = $req->input("chargingdivision");

        $id              = Auth::id();

        // add to charging tables
        $charging_collection = [
            "chargingname"      => $budgetname,
            "divisionid"        => $divisionid,
            "status"            => 1
        ];

        $save       = chargingtbl::create($charging_collection);
        $chargeid   = $save->chargingid;

        // add to budgetview 

        $plannedamount  = str_replace(",","",$plannedamount);
        $actualamount   = str_replace(",","",$actualamount);
      //  $plannedamount  = str_replace(",","",$plannedamount);

        $collection     = [
            "divid"         => $chargeid,
            "planned"       => $plannedamount,
            "actual"        => $actualamount,
            "year"          => $budgetyear,
            "isactive"      => 1
        ];

        $save = budgetview::create($collection);

        if ($save) {
            return redirect("/divisionwindow")->with("status","Budget Added");
        }
    }

    function postupdatebudget(Request $req) {
        $chargingid   = $req->input("chargingid");
        $charging_div = $req->input("update_chargingdivision"); // -> chargingtbls
        $budgetname   = $req->input("update_budgetname"); // -> chargingtbls
        $budgetyear   = $req->input("update_budgetyear"); // -> budgetviews
        $planned      = $req->input("update_plannedamount"); // -> budgetviews
        $actual       = $req->input("update_actualamount"); // -> budgetviews
        $isactive     = $req->input("isactive");
        
        // $b = str_replace( ',', '', $a );
        $planned      = str_replace(',', '', $planned);
        $actual       = str_replace(',', '', $actual);

        // update chargingtbls 
        $update       = chargingtbl::where("chargingid",$chargingid)->update(["chargingname"=>$budgetname,"divisionid"=>$charging_div]);
        $update       = budgetview::updateOrCreate(
                            ["divid"=>$chargingid],
                            ["planned"=>$planned,"actual"=>$actual,"year"=>$budgetyear,"isactive"=>$isactive]
                        );
        // $update       = budgetview::where("divid",$chargingid)->update(["planned"=>$planned,"actual"=>$actual,"year"=>$budgetyear,"isactive"=>$isactive]);
        
        if ($update) {
            return redirect("/divisionwindow/{$chargingid}/information")->with("infoupdate","Budget Information Updated!");
        }

        die("Error on updating");
    }

    function displaycharges(Request $req) {

        $returnhtml = view("chargestable",compact());
    }

    function allactivities($divid = null) {
        $id         = Auth::id();
        $division   = loginControl::join("divisiontbls","login_controls.divisionid","=","divisiontbls.divisionid")
                                    ->where("login_controls.userid",$id)
                                    ->get();

        $activities = inputwindow::where("division",$divid)->get();

        // $charges    = [];

        // if (count($activities) > 0) {
        //     $charges    = chargingto::where("activitygrpid",$activities[0])
        // } 
        

        return view("allactivities", compact("activities","division","divid"));
    }

    function divisionbudget($divid = null) {

    }
}