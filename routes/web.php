<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [loginController::class, "get"]);

Route::post('/login', [loginController::class, "post"]);

Route::get("/logout", [logoutController::class, "get"]);