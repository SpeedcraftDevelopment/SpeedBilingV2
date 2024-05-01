<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class emailController extends Controller
{
    public function page(){
        if(!Auth::check()){
            return redirect()->route("user.login");
        }
        return view("auth.emailVeryfication");
    }
}
