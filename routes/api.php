<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register','register')->name('register');
    Route::post('/auth/login','login')->name('login');

    Route::post('/forgot-password', 'forgotPassword')->name('password.forgot');
    Route::post('/reset-password', 'resetPassword')->name('password.reset');
});

Route::controller(UserController::class)->group(function () {
    Route::put('/users/{user}', 'update')->middleware('auth:api')->name('users.update');
});
