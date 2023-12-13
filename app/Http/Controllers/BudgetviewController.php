<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\budgetview;
use App\Models\chargingto;
use App\Models\inputwindow;

use Auth;
use DB;
// use \stdClass

class BudgetviewController extends Controller
{
    //

    function budgetviewwindow() {
        $values      = $this->getthebudgetvalues();
        $activities  = $this->getactivities();

        $planned     = $values['planned'];
        $actual      = $values['actual'];
        $spent       = $this->getexpenditure();
        $lefttospend = $actual-$spent;

        return view("budget", compact("planned","actual","spent","lefttospend","activities"));
    }

    function charges($divid = null) {

    }

    function activities($divid = null) {
        $activities  = $this->getactivities($divid);

        $new_act        = array_map(function($a){
            //$obj         = new \stdClass();

            $lastupdate  = null;
            $lastpoint   = null;
            $currentdate = date("Y-m-d");

            if ($a->daterelease != null) {
                $lastupdate = date("Y-m-d", strtotime($a->daterelease));
                $lastpoint  = "Director's Office";
            }

            if ($a->daterecvbyoc != null) {
                $lastupdate = date("Y-m-d", strtotime($a->daterecvbyoc));
                $lastpoint  = "Received by OC";
            }

            if ($a->datereleasedbyoc != null) {
                $lastupdate = date("Y-m-d", strtotime($a->datereleasedbyoc));
                $lastpoint  = "Released from OC";
            }

            if ($a->daterecvbyproc != null) {
                $lastupdate = date("Y-m-d", strtotime($a->daterecvbyproc));
                $lastpoint  = "Procurement";
            }

            $date1  = new \DateTime($lastupdate);
            $date2  = new \DateTime($currentdate);

            // $obj->{"maturity"} = $date1->diff($date2);
            $interval             = $date1->diff($date2);
            $a->{"maturity"}      = $interval->days . " days";
            $a->{"lastpoint"}     = $lastpoint;

            return $a;
        }, $activities);

       // var_dump($activities);

        return view("activities",compact('activities','divid'));
    }

    function getofficebudget() {
        $values      = $this->getthebudgetvalues();
        $planned     = $values['planned'];
        $actual      = $values['actual'];
        $spent       = $this->getexpenditure();
        $lefttospend = $actual-$spent;

        return response()->json([$planned,$actual,$spent,$lefttospend]);
    }

    function getexpenditure() {
        $wherein = budgetview::where("isactive","1")->get("divid")->toArray();
        $values = chargingto::select("actualcost")
                   ->join("inputwindows","chargingtos.activitygrpid","=","inputwindows.activitygrpid")
                   ->whereIn("chargeto",$wherein)
                   ->where("inputwindows.status",100)
                   ->sum("chargingtos.actualcost");

        return $values;
    }

    function getthebudgetvalues() {
        $budget = budgetview::where("isactive","1")->get();

        $planned = 0;
        $actual  = 0;

        foreach($budget as $b) {
            $planned = $planned+$b->planned;
            $actual  = $actual+$b->actual;
        }

        return ["planned"=>$planned,"actual"=>$actual];
    }

    function getperdivisionaverall() {
        $lefttospend  = [];
        $actualbudget = [];
        $spent        = [];
        $labels       = [];

        // $values = DB::select("select actual, sum(actualcost) as spent, chargingname from budgetviews 
        //                       join chargingtos on budgetviews.divid = chargingtos.chargeto 
        //                       join chargingtbls on chargingtos.chargeto = chargingtbls.chargingid 
        //                       where budgetviews.isactive = 1 group by divid;");

        // $values = DB::select("select actual, sum(chargingtos.actualcost) as spent, chargingname from budgetviews 
        //                       left join chargingtos on budgetviews.divid = chargingtos.chargeto 
        //                       left join chargingtbls on chargingtos.chargeto = chargingtbls.chargingid 
        //                       left join inputwindows on chargingtos.activitygrpid = inputwindows.activitygrpid 
        //                       where budgetviews.isactive = 1 group by divid;");

        $values = DB::select("select actual, sum(chargingtos.actualcost) as spent, chargingname, inputwindows.status as activitystatus,  
                              divid from budgetviews 
                              left join chargingtbls on budgetviews.divid = chargingtbls.chargingid 
                              left join chargingtos on budgetviews.divid = chargingtos.chargeto 
                              left join inputwindows on chargingtos.activitygrpid = inputwindows.activitygrpid 
                              where budgetviews.isactive = 1 group by divid;");

        $values2 = DB::select("select actual, sum(chargingtos.actualcost) as spent, chargingname, inputwindows.status as activitystatus, 
                              divid from budgetviews 
                              left join chargingtbls on budgetviews.divid = chargingtbls.chargingid 
                              left join chargingtos on budgetviews.divid = chargingtos.chargeto 
                              left join inputwindows on chargingtos.activitygrpid = inputwindows.activitygrpid 
                              where budgetviews.isactive = 1 and inputwindows.status = 100 group by divid;");

        // and inputwindows.status = 100 

        if (count($values) > 0) {
            foreach($values as $v) {
                array_push($labels, $v->chargingname);
                array_push($actualbudget,$v->actual);

                $lts = $v->actual;
                foreach($values2 as $v2) {
                   
                    if ($v->divid == $v2->divid) {
                        $lts = $v->actual-$v2->spent;

                        array_push($spent, $v2->spent);
                    } 
                }
                array_push($lefttospend, $lts);
            }
        }

        return response()->json(["label"=>$labels,"lefttospend"=>$lefttospend,"actualbudget"=>$actualbudget,"spent"=>$spent]);
    }

    function getactivities($divid = null) {
        $getwhat    = "all";
        $pppkdodivs = [1,2,3,4];

        // $collection = chargingto::select("inputwindows.*","chargingtos.chargewhat","chargingtos.actualcost as spent","chargingtbls.chargingname","divisiontbls.divaccr")
        //                 ->join("inputwindows","chargingtos.activitygrpid","=","inputwindows.activitygrpid")
        //                 ->join("chargingtbls","chargingtos.chargeto","=","chargingtbls.chargingid")
        //                 ->join("divisiontbls","inputwindows.division","=","divisiontbls.divisionid")
        //                 ->whereIn("inputwindows.division",$pppdodivs)
        //                 ->get();

        $collection    = DB::select("SELECT inputwindows.*, sum(chargingtos.actualcost) as acost, divisiontbls.divfullname, divisiontbls.divaccr FROM inputwindows join chargingtos on inputwindows.activitygrpid = chargingtos.activitygrpid join divisiontbls on inputwindows.division = divisiontbls.divisionid where inputwindows.division in (1,2,3,4) GROUP by activitygrpid");

        if ($divid != null) {
            $collection    = DB::select("SELECT inputwindows.*, sum(chargingtos.actualcost) as acost, divisiontbls.divfullname, divisiontbls.divaccr FROM inputwindows join chargingtos on inputwindows.activitygrpid = chargingtos.activitygrpid join divisiontbls on inputwindows.division = divisiontbls.divisionid where inputwindows.division = {$divid} GROUP by activitygrpid");
        
        }

        return $collection;
    }
}
