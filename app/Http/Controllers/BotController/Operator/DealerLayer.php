<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Dealer;
use Telegram\Bot\Laravel\Facades\Telegram;

class DealerLayer
{
    public static function getList($update)
    {
        $per_page = 10;

        $dealers = Dealer::take($per_page)->get();

        $text = "<b>👨‍💼 Dealers "
            . 1 . '-' . count($dealers)
            . ' of ' . Dealer::count() . "</b>\n\n";

        for ($i = 0; $i < count($dealers); $i++)
            $text .= $i + 1 . '. ' . $dealers[$i]->lastname . ' ' . $dealers[$i]->firstname . "\n";

        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::dealersList(
                dealers: $dealers,
                next: $per_page < Dealer::count()
            ),
            'text' => $text,
        ]);
    }




    public static function editList($update, int $need_page)
    {
        $per_page = 10;
        $skipped = ($need_page - 1) * $per_page;

        $dealers = Dealer::skip($skipped)->take($per_page)->get();

        $text = "<b>👨‍💼 Dealers "
            . $skipped + 1 . '-' . $skipped + count($dealers)
            . ' of ' . Dealer::count() . "</b>\n\n";

        for ($i = 0; $i < count($dealers); $i++)
            $text .= $i + 1 . '. ' . $dealers[$i]->lastname . ' ' . $dealers[$i]->firstname . "\n";

        $update->bot->editMessageText([
            'chat_id' => $update->chat_id,
            'parse_mode' => 'html',
            'message_id' => $update->message_id,
            'reply_markup' => KeyboardLayout::dealersList(
                dealers: $dealers,
                current_page: $need_page,
                prev: $skipped !== 0,
                next: $skipped + $per_page < Dealer::count()
            ),
            'text' => $text,
        ]);
    }





    public static function getInfo($update, $id)
    {
        $dealer = Dealer::find($id);

        if (!$dealer) return;

        $text = "<b>👨‍💼 Dealer </b>\n\n"
            . "ID: " . $dealer->id . "\n"
            . "Firstname: " . $dealer->firstname . "\n"
            . "Lastname: " . $dealer->lastname . "\n"
            . "Contact: " . $dealer->contact . "\n"
            . "Number of cars: " . $dealer->cars()->count();

        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'parse_mode' => 'html',
            'text' => $text,
        ]);
    }





    public static function removeList($update)
    {
        $update->bot->deleteMessage([
            'chat_id' => $update->chat_id,
            'message_id' => $update->message_id,
        ]);

        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('operator'),
            'text' => trans('msg.choose_section'),
        ]);
    }
}
