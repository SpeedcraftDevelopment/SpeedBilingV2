<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class registerController extends Controller
{
    function get(){
        if(Auth::check()){
            return redirect()->intended(route("main"));
        }
        return view("user.register");
    }

    function post(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'rpassword' => 'required',
        ]);

        if(!$validated){
            return back()->withErrors([
                'data' => "Sended data is not correct",
            ]);
        }

        if(User::where('email', $request->input("email"))->first()){
            return back()->withErrors([
                'email' => "Account with that e-mail already exists!",
            ]);
        }
        if(User::where('name', $request->input("name"))->first()){
            return back()->withErrors([
                'name' => "Account with that name already exists!",
            ]);
        }
        if($validated["password"]!==$validated["rpassword"]){
            return back()->withErrors([
                'password' => "Passwords are not the same!",
            ]);
        }

        $user = new User();

        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];

        $user->save();

        Auth::login($user);

        return redirect(route("main"));
    }
}
