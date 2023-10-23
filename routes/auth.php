<?php

use App\Http\Controllers\PanelController\Auth\LoginController;
use App\Http\Controllers\PanelController\Auth\ProfileController;
use App\Http\Controllers\PanelController\Auth\RegisterController;
use App\Http\Controllers\PanelController\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('home'));
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile-change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::get('/profile-delete', [ProfileController::class, 'deleteAccountShowModal'])->name('delete');
    Route::delete('/profile-delete', [ProfileController::class, 'deleteAccount']);
});

Route::middleware('guest')->group(function () {
    // Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
