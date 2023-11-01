<?php

\Illuminate\Support\Facades\Route::get('/set-webhook', function () {
    try {

        $operator_bot = \Telegram\Bot\Laravel\Facades\Telegram::bot('operator-bot')
            ->setWebhook(['url' => env('APP_URL') . "/api/webhook/operators"]);
        $dealer_bot = \Telegram\Bot\Laravel\Facades\Telegram::bot('dealer-bot')
            ->setWebhook(['url' => env('APP_URL') . "/api/webhook/dealers"]);
        $user_bot = \Telegram\Bot\Laravel\Facades\Telegram::bot('user-bot')
            ->setWebhook(['url' => env('APP_URL') . "/api/webhook/users"]);

        return view('setting.webhook')
            ->with('operator_bot', $operator_bot)
            ->with('dealer_bot', $dealer_bot)
            ->with('user_bot', $user_bot);


        // 
    } catch (\Exception $e) {

        $message = $e->getMessage();
        $lineNumber = $e->getLine();
        $file = $e->getFile();

        $alert_error = (object) [
            'primary' => 'Error',
            'text' => "$message (Line $lineNumber in $file)",
        ];

        return view('setting.webhook')
            ->with('alert_error', $alert_error);

        // 
    }
})->middleware('auth')->name('set-webhook');
