<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class logoutController extends Controller
{
    function get(){
        Auth::logout();
        return redirect("/");
    }
}
