<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Queue;

class BidLayer
{
    public static function getList($update)
    {
        $per_page = 5;

        $queue_id = json_decode($update->tg_chat->data)->queue_id;
        $queue = Queue::find($queue_id);
        if (!$queue) return;
        $auction = $queue->queueable;
        $bids = $auction->bids()->orderByDesc('price')->take($per_page)->get();

        $text = '';

        for ($i = 0; $i < count($bids); $i++)
            $text .= trans('msg.bidder', [
                'number' => $i + 1,
                'price' => $bids[$i]->price,
                'fname' => $bids[$i]->dealer->firstname,
                'lname' => $bids[$i]->dealer->lastname,
                'phone' => $bids[$i]->dealer->contact,
            ]);

        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::bidsList(
                queue: $queue,
                next: $per_page < $auction->bids()->count()
            ),
            'text' => trans('msg.bids_list', [
                'first_num' => 1,
                'last_num' => count($bids),
                'all_num' => $auction->bids()->count(),
                'slot' => $text,
                'owner_fname' => $auction->car->user->firstname,
                'owner_lname' => $auction->car->user->lastname,
                'owner_phone' => $auction->car->user->contact,
            ]),
        ]);
    }




    public static function editList($update, int $need_page)
    {
        $per_page = 5;
        $skipped = ($need_page - 1) * $per_page;

        $queue_id = json_decode($update->tg_chat->data)->queue_id;
        $queue = Queue::find($queue_id);
        if (!$queue) return;
        $auction = $queue->queueable;
        $bids = $auction->bids()->orderByDesc('price')->skip($skipped)->take($per_page)->get();

        $text = '';

        for ($i = 0; $i < count($bids); $i++)
            $text .= trans('msg.bidder', [
                'number' => $i + $skipped + 1,
                'price' => $bids[$i]->price,
                'fname' => $bids[$i]->dealer->firstname,
                'lname' => $bids[$i]->dealer->lastname,
                'phone' => $bids[$i]->dealer->contact,
            ]);

        $update->bot->editMessageText([
            'chat_id' => $update->chat_id,
            'parse_mode' => 'html',
            'message_id' => $update->message_id,
            'reply_markup' => KeyboardLayout::bidsList(
                queue: $queue,
                current_page: $need_page,
                prev: $skipped !== 0,
                next: $skipped + $per_page < $auction->bids()->count()
            ),
            'text' => trans('msg.bids_list', [
                'first_num' => 1,
                'last_num' => count($bids),
                'all_num' => $auction->bids()->count(),
                'slot' => $text,
                'owner_fname' => $auction->car->user->firstname,
                'owner_lname' => $auction->car->user->lastname,
                'owner_phone' => $auction->car->user->contact,
            ]),
        ]);
    }






    public static function taskDone($update, $queue_id)
    {
        $queue = Queue::find($queue_id);
        if (!$queue) return;
        $update->bot->deleteMessage([
            'chat_id' => $update->chat_id,
            'message_id' => $update->message_id,
        ]);
        QueueController::finish($queue, 'done');
        return $update->tg_chat->update(['action' => 'home>end']);
    }
}
