<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Business\BusinessController;
use App\Http\Controllers\API\V1\Service\ServiceController;
use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::prefix('auth')->group(function () {

        Route::post('register', [
            AuthController::class,
            'register',
        ]);

        Route::post('login', [
            AuthController::class,
            'login',
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Public Businesses
    |--------------------------------------------------------------------------
    */

    Route::get('businesses', [
        BusinessController::class,
        'index',
    ]);

    Route::get('businesses/{business:slug}', [
        BusinessController::class,
        'show',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Public Services
    |--------------------------------------------------------------------------
    */

    Route::get('businesses/{business}/services', [
        ServiceController::class,
        'index',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Authenticated User
        |--------------------------------------------------------------------------
        */

        Route::post('auth/logout', [
            AuthController::class,
            'logout',
        ]);

        Route::get('user', [
            UserController::class,
            'me',
        ]);

        Route::get('users/{user}', [
            UserController::class,
            'show',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Businesses
        |--------------------------------------------------------------------------
        */

        Route::post('businesses', [
            BusinessController::class,
            'store',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        Route::post('businesses/{business}/services', [
            ServiceController::class,
            'store',
        ]);
    });
});
