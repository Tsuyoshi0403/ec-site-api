<?php

use App\Http\Controllers\ApiProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ApiProductController::class);