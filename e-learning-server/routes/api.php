<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Parents\ParentsController;
use App\Http\Controllers\Student\TestController;


Route::group(['prefix'=> 'user', 'middleware' => 'auth:api'], function(){

    Route::group(['prefix' => 'student',  'middleware' => 'auth.student'], function(){
        Route::get('/test', [TestController::class, 'test']);
    });

    Route::group(['prefix' => 'teacher'], function(){

    });

    Route::group(['prefix' => 'parent'], function(){
        Route::get("get_parent",[ParentsController::class,"getParent"]);
        Route::get("get_child",[ParentsController::class,"getChild"]);

    });

    Route::group(['prefix' => 'admin'], function(){

    });

    Route::get("profile", [AuthController::class, "profile"]);
    Route::post("logout", [AuthController::class, "logout"]);
    Route::post("refresh", [AuthController::class, "refresh"]);
});


Route::group(['prefix' => 'guest'], function(){
    Route::get("unauthorized", [AuthController::class, "unauthorized"])->name("unauthorized");
    Route::post('/login', [AuthController::class, 'login']);
});