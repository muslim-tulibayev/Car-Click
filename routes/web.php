<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // todo: use only method

    Route::get('/auctions/{auction}/dealers', [App\Http\Controllers\PanelController\AuctionController::class, 'showDealers'])
        ->name('auctions.dealers');
    Route::get('/auctions/{auction}/bids', [App\Http\Controllers\PanelController\AuctionController::class, 'showBids'])
        ->name('auctions.bids');
    Route::resource('auctions', App\Http\Controllers\PanelController\AuctionController::class);

    Route::resource('users', App\Http\Controllers\PanelController\UserController::class);
    Route::resource('dealers', App\Http\Controllers\PanelController\DealerController::class);
    Route::resource('operators', App\Http\Controllers\PanelController\OperatorController::class);

    Route::resource('userchats', App\Http\Controllers\PanelController\UserChatController::class);
    Route::resource('dealerchats', App\Http\Controllers\PanelController\DealerChatController::class);
    Route::resource('operatorchats', App\Http\Controllers\PanelController\OperatorChatController::class);

    Route::resource('cars', App\Http\Controllers\PanelController\CarController::class);
    Route::resource('bids', App\Http\Controllers\PanelController\BidController::class);

    Route::get('/tasks/{task}/finish', [App\Http\Controllers\PanelController\TaskController::class, 'finishTask'])
        ->name('finish-task');
    Route::resource('tasks', App\Http\Controllers\PanelController\TaskController::class);

    Route::resource('settings', App\Http\Controllers\PanelController\SettingController::class)
        ->only(['index', 'edit', 'update']);

    Route::delete('/alerts/{alert}', [App\Http\Controllers\PanelController\AlertController::class, 'destroy'])
        ->name('alerts.destroy');
    Route::get('/alerts', [App\Http\Controllers\PanelController\AlertController::class, 'index'])
        ->name('alerts.index');
    Route::delete('/alerts', [App\Http\Controllers\PanelController\AlertController::class, 'destroyAll'])
        ->name('alerts.destroy-all');
});

require __DIR__ . '/telegram.php';
require __DIR__ . '/auth.php';
