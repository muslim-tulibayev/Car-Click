<?php

namespace App\Http\Controllers\BotController;

use App\Http\Controllers\BotController\Dealer\Action;
use App\Http\Controllers\BotController\Dealer\Command;
use App\Http\Controllers\BotController\Dealer\FreeCallback;
use App\Http\Controllers\BotController\Dealer\Update;
use App\Http\Controllers\Controller;
use App\Models\Alert;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class DealerController extends Controller
{
    public function handle(Request $request)
    {
        try {


            $update = Update::handle($request);
            $update->bot = Telegram::bot('dealer-bot');
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



            // 
        } catch (Exception $e) {
            $message = $e->getMessage();
            $lineNumber = $e->getLine();
            $file = $e->getFile();
            $error = "$message (Line $lineNumber in $file) -> [DealerController catch]";
            Log::error($error);
            Alert::create([
                'type' => 'error',
                'message' => $error,
            ]);
        }
    }
}
