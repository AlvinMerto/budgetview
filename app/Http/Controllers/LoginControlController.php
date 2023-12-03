<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;
use Hash;

class LoginControlController extends Controller
{
    //
    function postlogin(Request $req) {
        $email    = $req->input("email");
        $password = $req->input("password");

        if (Auth::attempt(["email"=>$email, "password"=>$password])) {
           return redirect("/budget");
        }

        return redirect("/")->with("status","User not Found");
    }

    function loginwindow() {
        if (Auth::user()) {
            return redirect("/budget");
        }
        return view("login");
    }

    function request() {
        if (Auth::user()) {
            return redirect("/budget");
        }

        return view("signup");
    }

    function postrequest(Request $req) {
        $email    = $req->input("email");
        $fullname = $req->input("fullname");
        $password = $req->input("password");

        $getemail = User::where("email",$email)->get("id");

        if (count($getemail) > 0) {
            return redirect("/request")->with("status","User is already registered");
        }

        $saveuser = [
            "name"      => $fullname,
            "email"     => $email,
            "password"  => Hash::make($password)
        ];

        $save = User::create($saveuser);

        if ($save) {
            return redirect("/request")->with("status","Success. You may now login, but the assignment of your account to a division is awaiting approval.");   
        }

        die("error");
    }

    function logout(){
        Auth::logout();
        return redirect("/");
    }
}
