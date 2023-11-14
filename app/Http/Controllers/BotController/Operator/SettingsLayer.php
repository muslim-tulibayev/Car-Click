<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Setting;
use App\Traits\SendValidatorMessagesTrait;
use Illuminate\Support\Facades\Validator;

class SettingsLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        switch ($update->action[2]) {
            case 'set_auction_duration':
                self::setAuctionDuration($update);
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
            case trans('msg.auction_duration_btn'):
                self::auctionDurationBtn($update);
                return true;
            case trans('msg.mute_btn'):
                self::mute($update, true);
                return true;
            case trans('msg.unmute_btn'):
                self::mute($update, false);
                return true;
            case trans('msg.back_btn'):
                self::back($update);
                return true;
            default:
                return false;
        }
    }





    private static function back($update)
    {
        $update->tg_chat->update(['action' => "home>end"]);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('operator'),
            'text' => trans('msg.choose_section'),
        ]);
    }





    private static function auctionDurationBtn($update)
    {
        $update->tg_chat->update(['action' => 'home>settings>set_auction_duration>waiting_duration_value']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_auction_duration'),
        ]);
    }






    private static function setAuctionDuration($update)
    {
        if ($update->action[3] !== 'waiting_duration_value')
            return;
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        $validator = Validator::make(
            ["duration" => $update->data],
            ["duration" => 'integer|min:5']
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $update->tg_chat->update(['action' => 'home>settings>end']);
        Setting::first()->update([
            'auction_expire_duration' => $update->data,
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::settingItems($update->tg_chat->operator),
            'text' => trans('msg.settings_updated'),
        ]);
    }





    private static function mute($update, bool $mute)
    {
        $update->tg_chat->update(['action' => 'home>settings>end']);

        $update->tg_chat->operator->update([
            'is_muted' => $mute,
        ]);

        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::settingItems($update->tg_chat->operator),
            'text' => trans('msg.settings_updated'),
        ]);
    }
}
