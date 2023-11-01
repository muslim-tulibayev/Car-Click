<?php

// todo

namespace App\Http\Controllers\BotController\Message;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;

class MessageLayout
{
    public static function chooseLang($update)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::chooseLang(),
            'text' => trans('msg.choose_lang'),
        ]);
    }

    public static function sendMessage($update, $text)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'text' => $text,
        ]);
    }

    public static function askContact($update)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::contact(),
            'text' => trans('msg.ask_contact', [
                'btn' => trans('msg.contact_btn')
            ]),
        ]);
    }

    public static function home($update, $type)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home($type),
            'text' => trans('msg.choose_section'),
        ]);
    }

    public static function cancelled($update)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::empty(),
            'text' => trans('msg.cancelled'),
        ]);
    }
}
