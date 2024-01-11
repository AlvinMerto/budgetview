<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyLeave;
use App\Models\User;

use Auth;
use Response;

class ApplyLeaveController extends Controller
{
    //
    function applyleave($leaveid = null) {

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

        return view("leave", compact("leave","leaveid","update","d","dates"));
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

        return redirect("/leave/{$grpid}");
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

    function monitoring() {
        $data = ApplyLeave::whereYear("dates","2024")->get();

        // $months = [
        //     "Jan" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Feb" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Mar" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Apr" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "May" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Jun" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Jul" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Aug" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Sep" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Oct" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Nov" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ],
        //     "Dec" => [
        //             "vleave"    => 0,
        //             "sleave"    => 0,
        //             "oleave"    => 0,
        //             "psperson"  => 0,
        //             "psoffic"   => 0
        //         ]
        // ];

        $months = [];
        $plus   = 0;
        foreach($data as $d) {
            if ($d->typeofleave == 1) {
                $months = [$d->userid => [date("M") => ['vleave' => $plus]]];
            } else if ($d->typeofleave == 3) {
                $months = [$d->userid => [date("M") => ['sleave' => $plus]]];
                // $months[$d->userid][date("M")]['sleave'] += 1;
            } else if ($d->typeofleave == 14) {
                $months = [$d->userid => [date("M") => ['psperson' => $plus]]];
                // $months[$d->userid][date("M")]['psperson'] += 1;
            } else if ($d->typeofleave == 15) {
                $months = [$d->userid => [date("M") => ['psoffic' => $plus]]];
                // $months[$d->userid][date("M")]['psoffic'] += 1;
            } else {
                $months = [$d->userid => [date("M") => ['oleave' => $plus]]];
                // $months[$d->userid][date("M")]['oleave'] += 1;
            }
        }
        // return view("leavedashboard",compact("months"));
    }
}
