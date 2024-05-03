<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\emailController;
use App\Http\Controllers\exceptionController;
use App\Http\Middleware\accountEmailVerifyMiddleware;
use App\Http\Middleware\authMiddleware;
use Illuminate\Support\Facades\Route;


require_once __DIR__ . '/user/getInOut.php';

require_once __DIR__ . "/user/emailVerification.php";

require_once __DIR__ . "/user/resetPassord.php";

Route::group(["prefix" => "/exception",
              "controller" => exceptionController::class], function(){
    Route::get("/badToken", "badToken")->name("exception.badToken");
});

Route::get('/', function () {
        return view('welcome');
    })->
    name("main")->
    middleware([authMiddleware::class, accountEmailVerifyMiddleware::class]);