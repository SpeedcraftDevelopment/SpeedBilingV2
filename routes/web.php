<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\registerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("main");

Route::get('/login', [loginController::class, "get"])->name("user.login");

Route::post('/login', [loginController::class, "post"]);

Route::get("/logout", [logoutController::class, "get"])->name("user.logout");

Route::get("/register", [registerController::class, "get"])->name("user.register");

Route::post("/register", [registerController::class, "post"]);