<?php

use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [loginController::class, "get"]);

Route::post('/login', [loginController::class, "post"]);