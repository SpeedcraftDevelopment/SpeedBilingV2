<?php

use App\Http\Controllers\authController;
use App\Http\Middleware\accountEmailVerifyMiddleware;
use App\Http\Middleware\authMiddleware;
use App\Http\Middleware\notAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(authController::class)->
    name("user.")->
    group(function(){
        Route::middleware([notAuthMiddleware::class, 
                           accountEmailVerifyMiddleware::class])->
            group(function(){
                Route::get('/login', "loginPage")->name("login");
                
                Route::post('/login', "login");
                
                Route::get("/register", "createPage")->name("register");
                
                Route::post("/register", "create");
            });

        Route::get("/logout", "logout")->
            name("user.logout")->
            middleware(authMiddleware::class);

    });