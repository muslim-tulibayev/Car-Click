<?php

use App\Http\Controllers\PanelController\AlertController;
use App\Http\Controllers\PanelController\AuctionController;
use App\Http\Controllers\PanelController\BidController;
use App\Http\Controllers\PanelController\CarController;
use App\Http\Controllers\PanelController\DealerChatController;
use App\Http\Controllers\PanelController\DealerController;
use App\Http\Controllers\PanelController\OperatorChatController;
use App\Http\Controllers\PanelController\OperatorController;
use App\Http\Controllers\PanelController\SettingController;
use App\Http\Controllers\PanelController\TaskController;
use App\Http\Controllers\PanelController\UserChatController;
use App\Http\Controllers\PanelController\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // * Auction
    Route::get('/auctions/{auction}/dealers', [AuctionController::class, 'showDealers'])
        ->name('auctions.dealers');
    Route::get('/auctions/{auction}/bids', [AuctionController::class, 'showBids'])
        ->name('auctions.bids');
    Route::get('/auctions/search/{col}/{val}', [AuctionController::class, 'search'])
        ->name('auctions.search');
    Route::resource('auctions', AuctionController::class);

    // * User
    Route::get('/users/search/{col}/{val}', [UserController::class, 'search'])
        ->name('users.search');
    Route::resource('users', UserController::class);
    Route::get('/userchats/search/{col}/{val}', [UserChatController::class, 'search'])
        ->name('userchats.search');
    Route::resource('userchats', UserChatController::class);

    // * Dealer
    Route::get('/dealers/search/{col}/{val}', [DealerController::class, 'search'])
        ->name('dealers.search');
    Route::resource('dealers', DealerController::class);
    Route::get('/dealerchats/search/{col}/{val}', [DealerChatController::class, 'search'])
        ->name('dealerchats.search');
    Route::resource('dealerchats', DealerChatController::class);

    // * Operator
    Route::get('/operators/search/{col}/{val}', [OperatorController::class, 'search'])
        ->name('operators.search');
    Route::resource('operators', OperatorController::class);
    Route::get('/operatorchats/search/{col}/{val}', [OperatorChatController::class, 'search'])
        ->name('operatorchats.search');
    Route::resource('operatorchats', OperatorChatController::class);

    // * Car
    Route::get('/cars/search/{col}/{val}', [CarController::class, 'search'])
        ->name('cars.search');
    Route::resource('cars', CarController::class);

    // * Task
    Route::get('/tasks/search/{col}/{val}', [TaskController::class, 'search'])
        ->name('tasks.search');
    Route::get('/tasks/{task}/finish', [TaskController::class, 'finishTask'])
        ->name('finish-task');
    Route::resource('tasks', TaskController::class);

    // * Bid
    Route::resource('bids', BidController::class);

    // * Alert
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])
        ->name('alerts.destroy');
    Route::get('/alerts', [AlertController::class, 'index'])
        ->name('alerts.index');
    Route::delete('/alerts', [AlertController::class, 'destroyAll'])
        ->name('alerts.destroy-all');

    // * Setting
    Route::resource('settings', SettingController::class)
        ->only(['index', 'edit', 'update']);
});

require __DIR__ . '/telegram.php';
require __DIR__ . '/auth.php';
