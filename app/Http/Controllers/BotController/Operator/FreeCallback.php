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
        // * If callback type is 'dealer' -> do not remove
        if ($type !== 'dealer')
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);

        switch ($type) {
            case 'queue':
                self::finishTask($update);
                return true;
            case 'dealer':
                self::getDealerInfo($update);
                return true;
            default:
                return false;
        }
    }




    private static function getDealerInfo($update)
    {
        $type = explode('|', $update->data)[1]; // * type [prev, cancel, next, info]
        $data = explode('|', $update->data)[2]; // * data: info -> dealer_id, prev|next|cancel -> current_page

        switch ($type) {
            case 'prev':
                DealerLayer::editList($update, $data - 1);
                break;
            case 'next':
                DealerLayer::editList($update, $data + 1);
                break;
            case 'info':
                DealerLayer::getInfo($update, $data);
                break;
            default:
                DealerLayer::removeList($update);
                break;
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
