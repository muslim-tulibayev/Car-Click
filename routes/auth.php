<?php

use App\Http\Controllers\PanelController\Auth\LoginController;
use App\Http\Controllers\PanelController\Auth\ProfileController;
use App\Http\Controllers\PanelController\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('home'));
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile-change-password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::delete('/profile-delete', [ProfileController::class, 'destroyAccount'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('api/login', function (){
        return response()->json(['message'=> 'Unauthenticated'],401);
    })->name('api.login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});
