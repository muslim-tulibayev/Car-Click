<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Dealer;

class HomeLayer
{

    public static function handle($update)
    {
        // * Gate
        if (!$update->tg_chat->operator) return;
        if (!$update->tg_chat->operator->is_validated) return;

        switch ($update->action[1]) {
            case 'car':
                CarLayer::handle($update);
                return true;
            case 'auction':
                AuctionLayer::handle($update);
                return true;
            case 'settings':
                SettingsLayer::handle($update);
                return true;
            case 'end':
                self::keywords($update);
                return true;
            default:
                return false;
        }
    }





    private static function keywords($update)
    {
        switch ($update->data) {
            case trans('msg.start_new_auction_btn'):
                self::startNewAuction($update);
                return true;
            case trans('msg.get_info_a_car'):
                self::getInfoCar($update);
                return true;
            case trans('msg.get_info_dealers'):
                self::getInfoDealers($update);
                return true;
            case trans('msg.settings_btn'):
                self::settings($update);
                return true;
            default:
                return false;
        }
    }





    private static function getInfoDealers($update)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'text' => trans('msg.dealers_info_msg', ['number' => Dealer::count()]),
        ]);
    }





    private static function getInfoCar($update)
    {
        $update->tg_chat->update(['action' => 'home>car>get_info>waiting_car_id']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_car_id'),
        ]);
    }





    private static function startNewAuction($update)
    {
        $update->tg_chat->update(['action' => 'home>auction>start_new>waiting_car_id']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_car_id'),
        ]);
    }




    private static function settings($update)
    {
        $update->tg_chat->update(['action' => 'home>settings>end']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::settingItems(),
            'text' => trans('msg.choose_section'),
        ]);
    }
}
