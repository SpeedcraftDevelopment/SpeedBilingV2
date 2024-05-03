<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class exceptionController extends Controller
{
    public function badToken(Request $request){

        if(!$request->has("message")){
            return redirect(route("main"));
        }
        
        return view("exception.badToken", ["message" => $request->message]);
    }
}
