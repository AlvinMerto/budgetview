<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\loginControl;
use App\Models\User;
use App\Models\divisiontbl;
use App\Models\chargingtbl;
use App\Models\chargingto;
use App\Models\chargetype;
use App\Models\inputwindow;

use DB;

class AdminwindowController extends Controller
{
    //

    function adminwindow() {
        $user       = User::all();
        $division   = divisiontbl::all();
        $assignment = loginControl::select("users.name","divisiontbls.divfullname")
                        ->join("users","login_controls.userid","=","users.id")
                        ->join("divisiontbls","login_controls.divisionid","=","divisiontbls.divisionid")
                        ->get();

        return view("adminwindow", compact("user","division","assignment"));
    }

    function postadduser(Request $req) {
        $user  = $req->input("thename");
        $div   = $req->input("thedivision");
        $atype = $req->input("userpower");

        $collection = [
            "userid"      => $user,
            "divisionid"  => $div,
            "accounttype" => $atype
        ];

        $save = loginControl::create($collection);

        if ($save) {
            return redirect("/divisionwindow")->with("status","User Added");
        }
    }

    function charge(Request $req, $grpid = null) {

        $division       = divisiontbl::all();
        $chargingtables = chargingtbl::all(); // chargingto::join("chargingtbls","chargingtos.chargeto","=","chargingtbls.chargingid")->get();
        $chargewhat     = chargetype::all();

        $inputwindow    = inputwindow::where("activitygrpid",$grpid)->get();

        $charges        = chargingto::join("chargingtbls","chargingtos.chargeto","=","chargingtbls.chargingid")
                          ->join("chargetypes","chargingtos.chargewhat","=","chargetypes.chargetypeid")
                          ->where("chargingtos.activitygrpid",$grpid)->get();

        return view("chargefromotherdivision", compact("division","chargingtables","chargewhat","inputwindow","grpid","charges"));
    }

    function deletefromtbl(Request $req) {
        $sql   = null;

        $id    = $req->input("id");
        $table = $req->input("table");
        // $grpid = $req->input("grpid");

        //if ($proceed == "true") {
            switch($table) {
                case "charging": $sql = "Delete from chargingtos where chargeid = '{$id}';"; break;
            }

            $delete = DB::delete($sql);

            return response()->json($delete); 
        //}
        // return view("delete");
    }
}