<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(!Auth::check()){
        return redirect()->route("user.login");
    }
    return view('welcome');
})->name("main");

Route::get('/login', [authController::class, "loginPage"])->name("user.login");

Route::post('/login', [authController::class, "login"]);

Route::get("/logout", [authController::class, "logout"])->name("user.logout");

Route::get("/register", [authController::class, "createPage"])->name("user.register");

Route::post("/register", [authController::class, "create"]);