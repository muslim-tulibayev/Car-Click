<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/webhook'], function () {
    Route::post('/operators', [App\Http\Controllers\BotController\OperatorController::class, 'handle']);
    Route::post('/dealers', [App\Http\Controllers\BotController\DealerController::class, 'handle']);
    Route::post('/users', [App\Http\Controllers\BotController\UserController::class, 'handle']);
});
