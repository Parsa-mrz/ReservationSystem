<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Business\BusinessController;
use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group( function () {

    // Public Routes
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });

    Route::controller(BusinessController::class)->prefix('businesses')->group(function () {
        Route::get('/', 'index');
        Route::get('/{slug}', 'show');
    });

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::controller(AuthController::class)->prefix('auth')->group(function () {
            Route::post('logout', 'logout');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('user', 'me');
            Route::get('users/{user}', 'show');
        });

        Route::controller(BusinessController::class)->prefix('businesses')->group(function () {
            Route::post('/', 'store');
        });
    });
});
