<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetviewController;
use App\Http\Controllers\InputwindowController;
use App\Http\Controllers\LoginControlController;
use App\Http\Controllers\DivisionwindowController;
use App\Http\Controllers\AdminwindowController;

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

Route::get("/logout",[LoginControlController::class,"logout"]);

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

Route::middleware("auth")->group(function(){
    // windows
    Route::get("/budget", [BudgetViewController::class,"budgetviewwindow"])->name("budget");
    Route::get("/divisionwindow/{chargingid?}/{tab?}",[DivisionwindowController::class,"divisionwindow"])->name("divisionwindow");
    Route::get("/adminwindow",[AdminwindowController::class,"adminwindow"])->name("adminwindow");
    Route::get("/inputwindow/{grpid?}",[InputwindowController::class,"inputwindow"])->name("inputwindow");

    Route::post("/getofficebudget",[BudgetViewController::class,"getofficebudget"]);
    Route::post("/getperdivisionaverall",[BudgetViewController::class,"getperdivisionaverall"]);
    
    Route::post("/postadduser",[AdminwindowController::class,"postadduser"])->name("postadduser");
    Route::post("/postbudgetentry",[DivisionwindowController::class,"postbudgetentry"])->name("postbudgetentry");

    Route::post("/getbudgetutilization_graph",[DivisionwindowController::class,"getbudgetutilization_graph"]);

    Route::post("/postupdatebudget",[DivisionwindowController::class,"postupdatebudget"])->name("postupdatebudget");

    Route::get("/displaycharges",[DivisionwindowController::class,"displaycharges"]);
    Route::get("/allactivities/{divid?}", [DivisionwindowController::class,"allactivities"])->name("allactivities");

    Route::post("/delete",[AdminwindowController::class,"deletefromtbl"])->name('delete');
});
