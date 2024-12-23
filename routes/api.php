<?php

use App\Http\Controllers\Api\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


//Login route
Route::post('/login', [AuthController::class, 'login']);
// Group routes that need JWT authentication
Route::middleware(['jwt.auth'])->group(function () {
    Route::apiResource('test', TestController::class);
});
