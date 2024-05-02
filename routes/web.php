<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\emailController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function (User $user) {
    if(!Auth::check()){
        return redirect()->route("user.login");
    }else{
        if(!$user->email_verified_at){
            return redirect()->route("email.veryfication-page");
        }
    }
    return view('welcome');
})->name("main");

Route::get('/login', [authController::class, "loginPage"])->name("user.login");

Route::post('/login', [authController::class, "login"]);

Route::get("/logout", [authController::class, "logout"])->name("user.logout");

Route::get("/register", [authController::class, "createPage"])->name("user.register");

Route::post("/register", [authController::class, "create"]);

Route::get("/email-veryfication", [emailController::class, "page"])->name("email.veryfication-page");

Route::get("/email-account-veryfiaction", [emailController::class, 'verify'])->name("email.veryfication.link");

Route::get("/email-send", [emailController::class, "sendEmail"])->name("email.send");