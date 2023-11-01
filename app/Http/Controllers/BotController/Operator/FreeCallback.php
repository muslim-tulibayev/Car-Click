<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Queue;
use Illuminate\Support\Facades\Log;

class FreeCallback
{
    public static function handle($update)
    {
        if ($update->type !== 'callback_query')
            return false;

        $type = explode('|', $update->data)[0]; // * type

        // * Remove each callbacks here first
        $update->bot->deleteMessage([
            'chat_id' => $update->chat_id,
            'message_id' => $update->message_id,
        ]);

        switch ($type) {
            case 'queue':
                self::finishTask($update);
                return true;
            default:
                return false;
        }
    }




    private static function finishTask($update)
    {
        $id = explode('|', $update->data)[1]; // * queue id
        $data = explode('|', $update->data)[2]; // * data [done, allow, deny, ignore]

        $operator = $update->tg_chat->operator;
        if (!($operator->queue and $operator->queue->id == $id)) return;

        $queue = Queue::find($id);
        if (!$queue) return;

        if ($queue->queueable instanceof \App\Models\Car and $data === 'allow') {
            $update->tg_chat->update([
                'action' => 'operation>validate_car>waiting_auction_start',
                'data' => json_encode(['car_id' => $queue->queueable->id]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'parse_mode' => 'html',
                'reply_markup' => KeyboardLayout::askStart(),
                'text' => trans('msg.ask_start'),
            ]);
        }

        QueueController::finish($queue, $data);
    }
}
