<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
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
    public function createPage(){
        if(Auth::check()){
            return redirect()->intended(route("main"));
        }
        return view("user.register");
    }

    public function login(Request $request){
        
        $user = User::where('email', $request->input("email"))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $pass = $request->input("password");

        if(Hash::check($pass, $user->password)){
            Auth::login($user);

            $request->session()->regenerate();
            
            return redirect()->intended(route("main"));
        }
        return back()->withErrors([
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    public function loginPage(){
        if(Auth::check()){
            return redirect()->intended(route("main"));
        }
        return view("user.login");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function logout(){
        Auth::logout();
        return redirect(route("main"));
    }
}
