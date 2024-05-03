<?php

use App\Http\Controllers\authController;
use App\Http\Middleware\accountEmailVerifyMiddleware;
use App\Http\Middleware\authMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(authController::class)->
    name("user.resetpassword.")->
    middleware([authMiddleware::class,
                accountEmailVerifyMiddleware::class])->
    group(function(){
        Route::get("/user/account/resetpassword", [authController::class, "resetPasswordPage"])->name("page");
        
        Route::get("/user/account/resetpassword/send", [authController::class, "resetPasswordSendEmail"])->name("sende-mail");
        
        Route::get("/user/account/resetpassword/reset", [authController::class, "resetPasswordSendEmail"])->name("reset");
    });