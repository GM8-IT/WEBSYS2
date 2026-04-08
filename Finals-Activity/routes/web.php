<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['web', \App\Http\Middleware\LogSystemEvent::class])->group(function () {

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

});