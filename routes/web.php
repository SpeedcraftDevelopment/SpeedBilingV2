<?php

use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(!Auth::check()){
        return redirect()->route("user.login");
    }
    return view('welcome');
})->name("main");

Route::get('/login', [userController::class, "loginPage"])->name("user.login");

Route::post('/login', [userController::class, "login"]);

Route::get("/logout", [userController::class, "logout"])->name("user.logout");

Route::get("/register", [userController::class, "createPage"])->name("user.register");

Route::post("/register", [userController::class, "create"]);