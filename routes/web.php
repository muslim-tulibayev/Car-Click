<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('auctions', App\Http\Controllers\PanelController\AuctionController::class);
    Route::resource('cars', App\Http\Controllers\PanelController\CarController::class);
    Route::resource('dealers', App\Http\Controllers\PanelController\DealerController::class);
    Route::resource('operators', App\Http\Controllers\PanelController\OperatorController::class);
    Route::resource('settings', App\Http\Controllers\PanelController\SettingController::class)
        ->only(['index', 'edit', 'update']);
    Route::resource('users', App\Http\Controllers\PanelController\UserController::class);
    Route::get('/queues/{queue}/finish', [App\Http\Controllers\PanelController\QueueController::class, 'finishQueue'])
        ->name('finish-queue');
    Route::resource('queues', App\Http\Controllers\PanelController\QueueController::class);
});

require __DIR__ . '/telegram.php';
require __DIR__ . '/auth.php';
