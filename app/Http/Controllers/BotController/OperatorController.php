<?php

namespace App\Http\Controllers\BotController;

use App\Http\Controllers\BotController\Operator\Action;
use App\Http\Controllers\BotController\Operator\Command;
use App\Http\Controllers\BotController\Operator\FreeCallback;
use App\Http\Controllers\BotController\Operator\Update;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class OperatorController
{
    public function handle(Request $request)
    {

        try {



            $update = Update::handle($request);
            $update->bot = Telegram::bot('operator-bot');
            app()->setLocale($update->tg_chat->lang ?? 'en');

            $completed = $update->type === 'unsupported';

            // * Commands
            if (!$completed)
                $completed = Command::handle($update);

            // * Free Callbacks
            if (!$completed)
                $completed = FreeCallback::handle($update);

            // * Actions
            if (!$completed)
                $completed = Action::handle($update);

            return;



            // 
        } catch (Exception $e) {
            $message = $e->getMessage();
            $lineNumber = $e->getLine();
            $file = $e->getFile();
            $error = "$message (Line $lineNumber in $file)";
            Log::error($error);
            // $update->bot->sendMessage([
            //     'chat_id' => $update->chat_id,
            //     'text' => $error,
            // ]);
        }
    }
}
