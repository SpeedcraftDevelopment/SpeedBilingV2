<?php

use App\Http\Controllers\authController;
use App\Http\Middleware\accountEmailVerifyMiddleware;
use App\Http\Middleware\authMiddleware;
use App\Http\Middleware\tokenVerifyMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(authController::class)->
    name("user.resetpassword.")->
    middleware([authMiddleware::class,
                accountEmailVerifyMiddleware::class])->
    group(function(){
        Route::get("/user/account/resetpassword", "resetPasswordPage")->name("page");
        
        Route::get("/user/account/resetpassword/send", "resetPasswordSendEmail")->name("sende-mail");
        
        Route::middleware([tokenVerifyMiddleware::class])->group(function(){
            Route::get("/user/account/resetpassword/reset", "resetPasswordPageVerify")->name("reset");
    
            Route::post("/user/account/resetpassword/submit", "resetPasswordPageSubmit")->name("submit");
        });
    });