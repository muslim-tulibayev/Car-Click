<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/set-webhook', function () {
    $res1 = Telegram::bot('operator-bot')
        ->setWebhook(['url' => env('APP_URL') . "/api/webhook/operators"]);
    dump('Operator: ' . ($res1 ? 'True' : 'False'));
    $res2 = Telegram::bot('dealer-bot')
        ->setWebhook(['url' => env('APP_URL') . "/api/webhook/dealers"]);
    dump('Dealer: ' . ($res2 ? 'True' : 'False'));
    $res3 = Telegram::bot('user-bot')
        ->setWebhook(['url' => env('APP_URL') . "/api/webhook/users"]);
    dump('User: ' . ($res3 ? 'True' : 'False'));
})->middleware('auth')->name('set-webhook');