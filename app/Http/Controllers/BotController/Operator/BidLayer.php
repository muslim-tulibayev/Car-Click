<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Auction;
use App\Models\Operator;
use App\Models\Task;
use Telegram\Bot\Laravel\Facades\Telegram;

class BidLayer
{
    public static function getList(Operator $operator, Auction $auction)
    {
        $per_page = 5;

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

        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::bidsList(
                task: $auction->taskable,
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

        $task_id = json_decode($update->tg_chat->data)->task_id;
        $task = Task::find($task_id);
        if (!$task) return;
        $auction = $task->taskable;
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
                task: $task,
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
}
