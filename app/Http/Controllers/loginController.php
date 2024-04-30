<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    function get(){
        if(Auth::check()){
            return redirect()->intended('/');
        }
        return view("user.login");
    }

    function post(Request $request){
        
        $user = User::where('email', $request->input("email"))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $pass = $request->input("password");
        $pass = hash("sha256", $pass);

        if($pass===$user->password){
            Auth::login($user);

            $request->session()->regenerate();
            
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'password' => 'The provided credentials do not match our records.',
        ]);
    }
}
