<?php

namespace App\Http\Controllers\BotController;

use App\Http\Controllers\BotController\Operator\Action;
use App\Http\Controllers\BotController\Operator\Command;
use App\Http\Controllers\BotController\Operator\FreeCallback;
use App\Http\Controllers\BotController\Operator\Update;
use App\Models\Alert;
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

            Log::alert(json_encode($update));

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
            $error = "$message (Line $lineNumber in $file) -> [OperatorController catch]";
            Log::error($error);
            Alert::create([
                'type' => 'error',
                'message' => $error,
            ]);
        }
    }
}
