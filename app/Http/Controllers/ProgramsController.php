<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\programs;

class ProgramsController extends Controller
{
    //
    function programs() {
        $programs = programs::where("programs.divisionid",1)
                            ->get();

        return view("programs", compact("programs"));
    }
}
