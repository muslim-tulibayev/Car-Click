<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/webhook'], function () {
    Route::post('/operators', [App\Http\Controllers\BotController\OperatorController::class, 'handle']);
    Route::post('/dealers', [App\Http\Controllers\BotController\DealerController::class, 'handle']);
    Route::post('/users', [App\Http\Controllers\BotController\UserController::class, 'handle']);
});

Route::controller(\App\Http\Controllers\API\AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

Route::get('auction', [\App\Http\Controllers\API\AuctionController::class, 'index']);
Route::get('auction/{id}', [\App\Http\Controllers\API\AuctionController::class, 'getDealer']);
