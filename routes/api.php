<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/sign-in', [AuthController::class, 'signIn']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/create', [UserController::class, 'create']);
        Route::put('/change/{user}', [UserController::class, 'change']);
        Route::get('/one/{user}', [UserController::class, 'one']);
        Route::post('/list', [UserController::class, 'listByPaginate']);
        Route::delete('/delete/{user}', [UserController::class, 'delete']);
    });


    Route::prefix('user/profile')->group(function () {
        Route::get('/detail', [ProfileController::class, 'detail']);
        Route::put('/change', [ProfileController::class, 'change']);
        Route::put('/changePassword', [ProfileController::class, 'changePassword']);
    });
});



