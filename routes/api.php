<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;


//Login route
Route::post('/login', [AuthController::class, 'login']);
// Group routes that need JWT authentication
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/test', [TestController::class, 'index']);
});
