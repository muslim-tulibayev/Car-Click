<?php

namespace App\Http\Controllers\BotController\Dealer;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use Telegram\Bot\Keyboard\Button;
use Telegram\Bot\Keyboard\Keyboard;

class HomeLayer
{

    public static function handle($update)
    {
        // * Gate
        if (!$update->tg_chat->dealer) return;

        switch ($update->action[1]) {
            case 'end':
                self::keywords($update);
                return true;
            case 'car':
                CarLayer::handle($update);
                return true;
            default:
                return false;
        }
    }





    private static function keywords($update)
    {
        switch ($update->data) {
            case trans('msg.my_cars_btn'):
                self::myCars($update);
                return true;
            default:
                return false;
        }
    }







    public static function myCars($update)
    {
        $cars = $update->tg_chat->dealer->cars()->get();
        if (!count($cars))
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.empty_cars'),
            ]);
        $update->tg_chat->update(['action' => 'home>car>show_one_car']);
        $keyboard = Keyboard::make()->inline();
        $j = 0;
        for ($i = count($cars) - 1; $i >= 0; $i--) {
            $j++;
            $text = $j . ': ' . $cars[$i]->company . ' ' . $cars[$i]->model;
            $keyboard->row([
                Button::make([
                    'text' => $text,
                    'callback_data' => $cars[$i]->id
                ])
            ]);
        }
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.choose_one_car'),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => $keyboard,
            'text' => trans('msg.your_cars'),
        ]);
    }
}
