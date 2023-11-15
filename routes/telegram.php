<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/set-webhook', function () {
    try {

        $operator_bot = Telegram::bot('operator-bot')
            ->setWebhook(['url' => env('APP_URL') . "/api/webhook/operators"]);
        $dealer_bot = Telegram::bot('dealer-bot')
            ->setWebhook(['url' => env('APP_URL') . "/api/webhook/dealers"]);
        $user_bot = Telegram::bot('user-bot')
            ->setWebhook(['url' => env('APP_URL') . "/api/webhook/users"]);

        return view('setting.webhook')
            ->with('operator_bot', $operator_bot)
            ->with('dealer_bot', $dealer_bot)
            ->with('user_bot', $user_bot);


        // 
    } catch (Exception $e) {

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






Route::get('/set-tg-cmds', function () {
    try {

        app()->setlocale(Setting::first()->system_lang);

        $commands_for_users = [
            [
                'command' => 'start',
                'description' => trans('msg.start_cmd'),
            ],
            [
                'command' => 'help',
                'description' => trans('msg.help_cmd'),
            ],
            [
                'command' => 'info',
                'description' => trans('msg.info_cmd'),
            ],
            [
                'command' => 'login',
                'description' => trans('msg.login_cmd'),
            ],
            [
                'command' => 'registration',
                'description' => trans('msg.registration_cmd'),
            ],
            [
                'command' => 'logout',
                'description' => trans('msg.logout_cmd'),
            ],
            [
                'command' => 'cancel',
                'description' => trans('msg.cancel_cmd'),
            ],
        ];

        $commands_for_dealers = [
            [
                'command' => 'start',
                'description' => trans('msg.start_cmd'),
            ],
            [
                'command' => 'help',
                'description' => trans('msg.help_cmd'),
            ],
            [
                'command' => 'info',
                'description' => trans('msg.info_cmd'),
            ],
            [
                'command' => 'login',
                'description' => trans('msg.login_cmd'),
            ],
            [
                'command' => 'registration',
                'description' => trans('msg.registration_cmd'),
            ],
            [
                'command' => 'logout',
                'description' => trans('msg.logout_cmd'),
            ],
            [
                'command' => 'cancel',
                'description' => trans('msg.cancel_cmd'),
            ],
        ];

        $commands_for_operators = [
            [
                'command' => 'start',
                'description' => trans('msg.start_cmd'),
            ],
            [
                'command' => 'help',
                'description' => trans('msg.help_cmd'),
            ],
            [
                'command' => 'info',
                'description' => trans('msg.info_cmd'),
            ],
            [
                'command' => 'login',
                'description' => trans('msg.login_cmd'),
            ],
            [
                'command' => 'registration',
                'description' => trans('msg.registration_cmd'),
            ],
            [
                'command' => 'logout',
                'description' => trans('msg.logout_cmd'),
            ],
            [
                'command' => 'cancel',
                'description' => trans('msg.cancel_cmd'),
            ],
            [
                'command' => 'task',
                'description' => trans('msg.task_cmd'),
            ],
        ];

        $operator_bot = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN_USER') . "/setMyCommands", ['commands' => $commands_for_users]);

        $dealer_bot = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN_DEALER') . "/setMyCommands", ['commands' => $commands_for_dealers]);

        $user_bot = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN_OPERATOR') . "/setMyCommands", ['commands' => $commands_for_operators]);

        return view('setting.set_tg_cmds')
            ->with('operator_bot', $operator_bot)
            ->with('dealer_bot', $dealer_bot)
            ->with('user_bot', $user_bot);


        // 
    } catch (Exception $e) {

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
})->middleware('auth')->name('set-tg-cmds');

// todo

// // if ($response->successful()) {
// //     $responseData = $response->json();
// //     dump($responseData);
// // } else {
// //     $statusCode = $response->status();
// //     $errorResponse = $response->json();
// //     dump($statusCode);
// //     dump($errorResponse);
// //         404 // app\Http\Controllers\PanelController\SettingController.php:93
// // array:3 [▼ // app\Http\Controllers\PanelController\SettingController.php:94
// //   "ok" => false
// //   "error_code" => 404
// //   "description" => "Not Found"
// // ]
// // }
