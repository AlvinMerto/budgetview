<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inputwindow;
use App\Models\chargingto;
use App\Models\chargingtbl;
use App\Models\loginControl;

use Auth;
use DB;

class InputwindowController extends Controller
{
    //

    function inputwindow($grpid = null) {
        $id             = Auth::id();

        $details        = [];
        $charging       = [];

        $chargingtables = $this->getcharging();

        if ($grpid != null) {
            $details  = inputwindow::where("activitygrpid",$grpid)->get();
            $charging = chargingto::join("chargingtbls","chargingtos.chargeto","=","chargingtbls.chargingid")
                        ->join("chargetypes","chargingtos.chargewhat","=","chargetypes.chargetypeid")
                        ->where("chargingtos.activitygrpid",$grpid)->orderBy("chargeid","DESC")->get();
        }

        $division = loginControl::join("divisiontbls","login_controls.divisionid","=","divisiontbls.divisionid")
                                  ->where("login_controls.userid",$id)->get();

        return view("inputwindow", compact("details","grpid","charging","chargingtables","division"));
    }

    function getcharging() {
        $collection = chargingtbl::join("budgetviews","chargingtbls.chargingid","=","budgetviews.divid")
                                  ->where("budgetviews.isactive",1)
                                  ->get();
        return $collection;
    }

    function getspent($chargingid) {
        $collection = DB::select("select sum(actualcost) as actualcost, budgetviews.actual as budgetactual from chargingtos 
                                  join budgetviews on chargingtos.chargeto = budgetviews.divid 
                                  where chargingtos.chargeto = {$chargingid}");

        return $collection;
    }

    function savecharging(Request $req) {
        $grpid      = $req->input("activitygrpid");
        $actualcost = $req->input("actualcost");
        $chargewhat = $req->input("chargewhat");
        $chargetype = $req->input("chargetype");

        $chargeto   = $req->input("chargeto");

        $checkbudget = $this->getspent($chargeto);

        if (count($checkbudget) == 0) {
            if (isset($_POST['addcharging_outside'])) {
                return redirect("/charge/{$grpid}")->with("status","There is no budget for this budget line");
            }

            return redirect("/inputwindow/{$grpid}")->with("status","There is no budget for this budget line");
        } else {
            $spent     = (int) $checkbudget[0]->actualcost;
            $budget    = (int) $checkbudget[0]->budgetactual;
            $remaining = $budget-$spent;

            if ($actualcost > $remaining) {
                if (isset($_POST['addcharging_outside'])) {
                    return redirect("/charge/{$grpid}")->with("status","The remaining budget is below the actual cost.");
                }

                return redirect("/inputwindow/{$grpid}")->with("status","The remaining budget is below the actual cost.");
            }
        }

        $values     = [
            "activitygrpid"     => $grpid,
            "actualcost"        => $actualcost,
            "chargewhat"        => $chargewhat,
            "chargeto"          => $chargeto,
            "chargetype"        => $chargetype
        ];

        $save = chargingto::create($values);

        // $save    = chargingto::updateOrCreate(
        //                 ["activitygrpid"=>$grpid],
        //                 ["actualcost"        => $actualcost,
        //                  "chargewhat"        => $chargewhat,
        //                  "chargeto"          => $chargeto,
        //                 "chargetype"         => $chargetype]
        //             );

        if ($save) {
            if (isset($_POST['addcharging_outside'])) {
                return redirect("/charge/{$grpid}");
            }
            return redirect("inputwindow/{$grpid}");
            // return response()->json( number_format($actualcost) );
        }
    }

    function saveactivity(Request $req) {

        $grpid            = $req->input("activitygrpid");

        if ( strlen($grpid) == 0 ) {
            $activitygrpid    = md5(date("mdyhis"));
        } else {
            $activitygrpid    = $grpid;
        }   

        $activitytitle    = $req->input("activitytitle");
        $initialcost      = $req->input("initialcost");    
        $dateofactivity   = $req->input("dateofactivity");
        $status           = $req->input("status");

        $daterelease      = $req->input("daterelease");
        if ( strlen($daterelease) == 0 ) {
            $daterelease  = null;
        } else {
            $daterelease  = date("Y-m-d", strtotime($req->input("daterelease")));
        }

        $daterecvdbyoc      = $req->input("daterecvdbyoc");
        if ( strlen($daterecvdbyoc) == 0 ) {
            $daterecvdbyoc  = null;
        } else {
            $daterecvdbyoc  = date("Y-m-d", strtotime($req->input("daterecvdbyoc")));
        }

        $datereleasedbyoc   = $req->input("datereleasedbyoc");
        if ( strlen($datereleasedbyoc) == 0 ) {
            $datereleasedbyoc  = null;
        } else {
            $datereleasedbyoc  = date("Y-m-d", strtotime($req->input("datereleasedbyoc")));
        }

        $datercvdbyproc   = $req->input("datercvdbyproc");
        if ( strlen($datercvdbyproc) == 0 ) {
            $datercvdbyproc  = null;
        } else {
            $datercvdbyproc  = date("Y-m-d", strtotime($req->input("datercvdbyproc")));
        }

        $division         = $req->input("divisionselect");

        $initialcost      = str_replace(',', '', $initialcost);

        $values = [
            "activitygrpid"       => $activitygrpid,
            "activitytitle"       => $activitytitle,    
            "initialcost"         => $initialcost,
            "actualcost"          => null,
            "dateofactivity"      => $dateofactivity,
            "daterelease"         => $daterelease,
            "daterecvbyoc"        => $daterecvdbyoc,
            "datereleasedbyoc"    => $datereleasedbyoc,
            "daterecvbyproc"      => $datercvdbyproc,
            "status"              => $status,
            "division"            => $division
        ];

        // updatebtn
        // savebtn

        // $save   = inputwindow::create($values);
        $save      = inputwindow::updateOrCreate(
                        ["activitygrpid"       => $activitygrpid],
                        ["activitytitle"       => $activitytitle,    
                         "initialcost"         => $initialcost,
                         "actualcost"          => null,
                         "dateofactivity"      => $dateofactivity,
                         "daterelease"         => $daterelease,
                         "daterecvbyoc"        => $daterecvdbyoc,
                         "datereleasedbyoc"    => $datereleasedbyoc,
                         "daterecvbyproc"      => $datercvdbyproc,
                         "status"              => $status,
                         "division"            => $division]
                    );

        if ($save) {
            if (isset($_POST['savebtn_outside'])) {
                return redirect("/charge/{$activitygrpid}");
            } 
            return redirect("/inputwindow/{$activitygrpid}");
        }

        die("Error Saving");
    }
}