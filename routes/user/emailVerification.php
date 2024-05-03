<?php

use App\Http\Controllers\emailController;
use App\Http\Middleware\authMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(emailController::class)->
    middleware(authMiddleware::class)->
    name("email.")->
    group(function(){
        Route::get("/user/account/veryfication", "accountVeryficationPage")->name("veryfication-page");
        
        Route::get("/user/account/veryfication/verify", 'accountVeryficationVerify')->name("veryfication.link");
        
        Route::get("/user/account/veryfication/send", "accountVeryficationEmailSend")->name("send");
    });