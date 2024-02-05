<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BudgetviewController;
use App\Http\Controllers\InputwindowController;
use App\Http\Controllers\LoginControlController;
use App\Http\Controllers\DivisionwindowController;
use App\Http\Controllers\AdminwindowController;
use App\Http\Controllers\ApplyLeaveController;
use App\Http\Controllers\ProgramsController;

use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginControlController::class,"loginwindow"])->name("login");
Route::post("/postlogin",[LoginControlController::class,"postlogin"])->name("postlogin");

Route::get('/request', [LoginControlController::class,"request"])->name("request");
Route::post("/postrequest",[LoginControlController::class,"postrequest"])->name("postrequest");

Route::get("/logout",[LoginControlController::class,"logout"])->name("logout");

//Route::middleware('auth:auth')->group(function () {

    // Other authenticated routes...
    Route::get("/login",function(){
        if (Auth::check(['email' => "test@example.com", 'password' => "123", false, false])) {
            // echo "logged in";

            $user = Auth::user();
            $user->createToken("testtoken");

        } else {
            echo "error";
        }
    });

//});

Route::get("/charge/{grpid?}",[AdminwindowController::class,"charge"])->name("charge");

Route::post("/saveactivity",[InputwindowController::class,"saveactivity"])->name("saveactivity");
// Route::post("/updateactivity",[InputwindowController::class,"updateactivity"])->name("updateactivity");
Route::post("/savecharging",[InputwindowController::class,"savecharging"])->name("savecharging");

Route::get("/trackit/{actgrpid?}",[InputwindowController::class,"trackit"])->name('trackit');
Route::post("/posttrackit",[InputwindowController::class,"posttrackit"])->name("posttrackit");

Route::get("/generateqr/{actgrpid?}",[InputwindowController::class,"generateqr"])->name("generateqr");

Route::middleware("auth")->group(function(){
    // windows
    Route::get("/budget", [BudgetviewController::class,"budgetviewwindow"])->name("budget");
    Route::get("/activities/{divid?}",[BudgetviewController::class,"activities"])->name("activities");
    Route::get("/charges",[BudgetviewController::class,"charges"])->name("charges");

    Route::get("/divisionwindow/{chargingid?}/{tab?}/{divisionid?}",[DivisionwindowController::class,"divisionwindow"])->name("divisionwindow");
    Route::get("/adminwindow",[AdminwindowController::class,"adminwindow"])->name("adminwindow");
    Route::get("/inputwindow/{grpid?}",[InputwindowController::class,"inputwindow"])->name("inputwindow");

    Route::post("/getofficebudget",[BudgetviewController::class,"getofficebudget"]);
    Route::post("/getperdivisionaverall",[BudgetviewController::class,"getperdivisionaverall"]);
    
    Route::post("/postadduser",[AdminwindowController::class,"postadduser"])->name("postadduser");
    Route::post("/postbudgetentry",[DivisionwindowController::class,"postbudgetentry"])->name("postbudgetentry");

    Route::post("/getbudgetutilization_graph",[DivisionwindowController::class,"getbudgetutilization_graph"]);

    Route::post("/postupdatebudget",[DivisionwindowController::class,"postupdatebudget"])->name("postupdatebudget");

    Route::get("/displaycharges",[DivisionwindowController::class,"displaycharges"]);
    Route::get("/allactivities/{divid?}", [DivisionwindowController::class,"allactivities"])->name("allactivities");

    Route::post("/delete",[AdminwindowController::class,"deletefromtbl"])->name('delete');

    Route::post("/getdivision_graph",[DivisionwindowController::class,"getdivision_graph"])->name("getdivision_graph");

    Route::get("/generateqr/{actgrpid?}/{title?}", [InputwindowController::class,"generateqr"])->name("generateqr");

    // leave applications
        Route::get("/leave/{leaveid?}/{typeofleave?}", [ApplyLeaveController::class,"applyleave"])->name("applyleave");

        Route::post("/postsaveleave",[ApplyLeaveController::class,"postsaveleave"])->name("postsaveleave");

        Route::get("/monitoring/{year}",[ApplyLeaveController::class,"monitoring"])->name("monitoring");

        Route::post("/get_pie_data",[ApplyLeaveController::class,"get_pie_data"])->name("get_pie_data");

        Route::get("/emps_with_most",[ApplyLeaveController::class,"emps_with_most"])->name("emps_with_most");
    // end 

    Route::get("/leaveapplication",[ApplyLeaveController::class,"leaveapplication"])->name("leaveapplication");
    Route::get("/passslipapplication",[ApplyLeaveController::class,"passslipapplication"])->name("passslipapplication");
    Route::get("/pafapplication",[ApplyLeaveController::class,"pafapplication"])->name("pafapplication");

    // programs
    Route::get("/programs",[ProgramsController::class,"programs"])->name("programs");
});