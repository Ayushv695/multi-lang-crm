<?php

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/refresh-token', 'refreshToken');
    });

    Route::controller(AuthController::class)->middleware('jwt')->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/logout', 'logout');
    });
});

Route::middleware('jwt')->group(function () {

    Route::get('/languages', [LanguageController::class,'index']);

    Route::middleware('role:admin')->controller(LanguageController::class)->group(function () {
        Route::post('/language', 'store');
        Route::put('/language/{id}', 'update');
        Route::delete('/language/{id}', 'destroy');
    });

    Route::controller(ItemController::class)->group(function(){
        Route::get('/items', 'index');
        Route::get('/item/{id}', 'show');
    });

    Route::middleware('role:admin')->controller(LanguageController::class)->group(function () {
        Route::post('/item', 'store');
        Route::put('/item/{id}', 'update');
        Route::delete('/item/{id}', 'destroy');
    });
});