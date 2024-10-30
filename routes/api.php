<?php

use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('products', ApiProductController::class);
});
Route::post("login", [UserController::class,'index']);
