<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inputwindow;
use App\Models\chargingto;
use App\Models\chargingtbl;
use App\Models\loginControl;
use App\Models\chargetype;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $chargetype = chargetype::all();

        return view("inputwindow", compact("details","grpid","charging","chargingtables","division","chargetype"));
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

            // if ($actualcost > $remaining) {
            //     if (isset($_POST['addcharging_outside'])) {
            //         return redirect("/charge/{$grpid}")->with("status","The remaining budget is below the actual cost.");
            //     }

            //     return redirect("/inputwindow/{$grpid}")->with("status","The remaining budget is below the actual cost.");
            // }
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

        $grpid                = $req->input("activitygrpid");

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

        $date_po          = $req->input("poreleased");
        if ( strlen($date_po) == 0 ) {
            $date_po = null;
        } else {
            $date_po  = date("Y-m-d", strtotime($req->input("poreleased")));
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
            "date_po"             => $date_po,
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
                         "date_po"             => $date_po,
                         "status"              => $status,
                         "division"            => $division]
                    );

        if ($save) {
            // $this->generateqr($activitygrpid,$activitytitle);

            if (isset($_POST['savebtn_outside'])) {
                return redirect("/charge/{$activitygrpid}");
            } 
            return redirect("/inputwindow/{$activitygrpid}");
        }

        die("Error Saving");
    }

    function generateqr($code) {
   
        $url = url("trackit")."/".$code;

        $pdf = Pdf::loadView("qrcode", compact("url"));

        return $pdf->download("activitydesign.pdf");
    }

    function trackit($code) {

        $collection = inputwindow::where("activitygrpid",$code)->get()->toArray();

        if (count($collection) == 0) {
            die("Activity design not found");
            return;
        }

        return view("trackit", compact("code","collection"));
    }

    function posttrackit(Request $req) {
        $code = $req->input("qid");
        $fld  = $req->input("fld");

        $datetoday = date("Y-m-d");

        $status    = 20;
        switch($fld) {
            case "daterelease":
                $status = 40;
                break;
            case "daterecvbyoc":
                $status = 60;
                break;
            case "datereleasedbyoc":
                $status = 80;
                break;
            case "daterecvbyproc":
                $status = 80;
                break;
            case "date_po":
                $status = 100;
                break;
        }

        $updated = inputwindow::where("activitygrpid",$code)->update([$fld=>$datetoday, "status" => $status]);

        if ($updated) {
            return redirect("trackit/{$code}")->with("msg","Document Received");
        }
    }
}
