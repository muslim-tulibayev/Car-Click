<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Queue;

class FreeCallback
{
    public static function handle($update)
    {
        if ($update->type !== 'callback_query')
            return false;

        $type = explode('|', $update->data)[0]; // * type

        switch ($type) {
            case 'queue':
                self::finishTask($update);
                return true;
            case 'dealer':
                self::getDealerInfo($update);
            case 'bid':
                self::getBidsInfo($update);
                return true;
            default:
                return false;
        }
    }





    private static function getBidsInfo($update)
    {
        $type = explode('|', $update->data)[1]; // * type: [prev, next]
        $data = explode('|', $update->data)[2]; // * data: [prev, next] -> current_page, [done] -> queue_id

        switch ($type) {
            case 'prev':
                BidLayer::editList($update, $data - 1);
                break;
            case 'next':
                BidLayer::editList($update, $data + 1);
                break;
            case 'done':
                BidLayer::taskDone($update, $data);
                break;
            case 'cancel':
                Command::cancel($update);
                break;
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
        // * Remove each callbacks here first
        $update->bot->deleteMessage([
            'chat_id' => $update->chat_id,
            'message_id' => $update->message_id,
        ]);

        $id = explode('|', $update->data)[1]; // * queue id
        $data = explode('|', $update->data)[2]; // * data [take, done, allow, deny, ignore]

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

        if ($queue->operation === 'finished_auction' and $data === 'take') {
            $update->tg_chat->update([
                'action' => 'operation>finished_auction',
                'data' => json_encode(['queue_id' => $queue->id]),
            ]);

            return BidLayer::getList($update);
        }

        QueueController::finish($queue, $data);
    }
}
