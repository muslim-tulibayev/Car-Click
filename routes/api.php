<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\API\AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

Route::get('auction', [\App\Http\Controllers\API\AuctionController::class, 'index']);
