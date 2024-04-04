<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyLeave;
use App\Models\User;

use Auth;
use Response;
use DB;

class ApplyLeaveController extends Controller
{
    //
    function applyleave($leaveid = null, $typeofleave = null) {

        $arr        = null;
        $update     = false;

        if ($leaveid != null) {
            $arr    = ["grpid"=>$leaveid];
            $update = true;
        } else {
            $arr    = ["userid"=>Auth::id()];
            $update = false;
        }

        $leave = ApplyLeave::where($arr)->get();

        $dates = [];
        $d     = null;

        if ($leaveid != null) {
            foreach($leave as $l) {
                array_push($dates,$l->dates);
            }

            $d = json_encode($dates);
        }

        $ownername = Auth::user()->name;
        $ownerid   = Auth::user()->id;

        $leaveform = null;
        if ($typeofleave != null) {
            switch($typeofleave) {
                case "1":
                case "2":
                case "3":
                case "4":
                case "5":
                case "6":
                case "7":
                case "8":
                case "9":
                case "10":
                case "11":
                case "12":
                case "13":
                    $leaveform = url("leaveapplication");
                    break;
                case "14":
                case "15":
                    $leaveform = url("passslipapplication");
                    break;
                case "16":
                    $leaveform = url("pafapplication");
                    break;
            }
        }

        return view("leave", compact("leave","leaveid","update","d","dates","ownername","ownerid","leaveform"));
    }

    function postsaveleave(Request $req) {
        $userid         = Auth::id();
        $dates          = (array) json_decode($req->input("selecteddates"));
        $typeofleave    = $req->input("leavetype");
        $reason         = $req->input("reasontxt");

        //  "userid","dates","typeofleave","reason","status","created_at","updated_at"
        $grpid          = md5(date("mdyhis"));

        foreach($dates as $d) {
            $save                   = new ApplyLeave();
            $save->userid           = $userid;
            $save->grpid            = $grpid;
            $save->dates            = $d;
            $save->typeofleave      = $typeofleave;
            $save->reason           = $reason;
            $save->status           = "approved";
            $save->save();
        }

        return redirect("/leave/{$grpid}/{$typeofleave}");
    }

    function leaveapplication() {
        //PDF file is stored under project/public/download/info.pdf
        $file    = storage_path(). "/document/applicationforleave.pdf";

        $headers = array(
                    'Content-Type: application/pdf',
                   );

        return Response::download($file, 'applicationforleave.pdf', $headers);

        // return view("leaveapplication");
    }

    function passslipapplication() {
        $file    = storage_path(). "/document/applicationpassslip.pdf";

        $headers = array(
                    'Content-Type: application/pdf',
                   );

        return Response::download($file, 'applicationpassslip.pdf', $headers);

    }

    function pafapplication() {
        $file    = storage_path(). "/document/applicationpaf.pdf";

        $headers = array(
                    'Content-Type: application/pdf',
                   );

        return Response::download($file, 'applicationpaf.pdf', $headers);
    }

    function monitoring($year) {
        if ($year == null || strlen($year) == 0) {
            die("Please specify the year");
        }

        $data  = ApplyLeave::whereYear("dates",$year)->get();
        $users = user::get();

        $months   = [];
        $names    = [];

        foreach($users as $u) {
            $vleave   = 0;
            $sleave   = 0;
            $psperson = 0;
            $psoffic  = 0;
            $oleave   = 0;
            
            foreach($data as $d) {
                if ($d->userid == $u->id) {
                    if ($d->typeofleave == 1) {
                        $vleave   = 1;

                        if (isset( $months[$d->thename->id][date("M", strtotime($d->dates))]['vleave']) ) {
                            $vleave =  $months[$d->thename->id][date("M", strtotime($d->dates))]['vleave']+1;
                        }

                        $months[$d->thename->id][date("M", strtotime($d->dates))]['vleave'] = $vleave;
                    } else if ($d->typeofleave == 3) {
                        $sleave   = 1; 
                        
                        if (isset($months[$d->thename->id][date("M", strtotime($d->dates))]['sleave'])) {
                            $sleave = $months[$d->thename->id][date("M", strtotime($d->dates))]['sleave']+1;
                        }

                        $months[$d->thename->id][date("M", strtotime($d->dates))]['sleave'] = $sleave;
                    } else if ($d->typeofleave == 14) {
                        $psperson = 1;

                        if ( isset($months[$d->thename->id][date("M", strtotime($d->dates))]['psperson']) ) {
                            $psperson = $months[$d->thename->id][date("M", strtotime($d->dates))]['psperson']+1;
                        }

                        $months[$d->thename->id][date("M", strtotime($d->dates))]['psperson'] = $psperson;
                    } else if ($d->typeofleave == 15) {
                        $psoffic = 1;

                        if ( isset($months[$d->thename->id][date("M", strtotime($d->dates))]['psoffic']) ) {
                            $psoffic = $months[$d->thename->id][date("M", strtotime($d->dates))]['psoffic']+1;
                        }

                        $months[$d->thename->id][date("M", strtotime($d->dates))]['psoffic'] = $psoffic;
                    } else {
                        $oleave = 1;

                        if (isset($months[$d->thename->id][date("M", strtotime($d->dates))]['oleave'])) {
                            $oleave = $months[$d->thename->id][date("M", strtotime($d->dates))]['oleave']+1;
                        }
                        
                        $months[$d->thename->id][date("M", strtotime($d->dates))]['oleave'] = $oleave;
                    }
                    
                    $names[$d->thename->id]['name'] = $d->thename->name;
                }
            }
        }
       
        // var_dump($months); return;
        return view("leavedashboard",compact("months","names","year"));
    }

    function get_pie_data(Request $req) {
        $year = $req->input("theyear");
        $data  = ApplyLeave::whereYear("dates",$year)->get();
        $users = user::get();

        $months   = [];
        $labels   = [];
        $lbl      = null;

            $vleave   = 0;
            $sleave   = 0;
            $psperson = 0;
            $psoffic  = 0;
            $oleave   = 0;
            
            foreach($data as $d) {
                if ($d->typeofleave == 1) {
                    $vleave           += 1;
                    $months['vleave'] = $vleave;
                    $lbl              = "Vacation Leave";
                } else if ($d->typeofleave == 3) {
                    $sleave   += 1;
                    $months['sleave'] = $sleave;
                    $lbl              = "Sick Leave";
                } else if ($d->typeofleave == 14) {
                    $psperson += 1;
                    $months['psperson'] = $psperson;
                    $lbl       = "Pass Slip: Personal";
                } else if ($d->typeofleave == 15) {
                    $psoffic += 1;
                    $months['psoffic'] = $psoffic;
                    $lbl       = "Pass Slip: Official";
                } else {
                    $oleave += 1;
                    $months['oleave'] = $oleave;
                    $lbl       = "Other Leave";
                }

                if (!in_array($lbl, $labels)) {
                    array_push($labels,$lbl);
                }
            }

        $months = array_values($months);
        return response()->json([$months,$labels]);
    }

    function emps_with_most(Request $req) {
        // $leavetype = $req->input("typeofleave");
        $year      = $req->input('year');
        $leavetype = $req->input("leavetype");
        
        $data      = DB::table("apply_leaves")
                        ->select(array("users.name","users.id",DB::raw('count(userid) as cnt')))
                        ->leftjoin("users","apply_leaves.userid","=","users.id")
                        ->where("typeofleave",$leavetype)
                        ->whereYear("dates",$year)
                        ->groupBy("userid")
                        ->get();
                    
        $html      = view("leavecount",compact("data"))->render();
        return response()->json($html);
    }
}
