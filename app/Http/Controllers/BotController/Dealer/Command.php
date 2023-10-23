<?php

namespace App\Http\Controllers\BotController\Dealer;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\DealerChat;

class Command
{
    public static function handle($update)
    {
        if ($update->type !== 'text' || $update->data[0] !== '/')
            return false;

        if (isset($update->tg_chat) and $update->tg_chat->action === 'start>choosing_lang')
            return $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);

        switch ($update->data) {
            case '/start':
                self::start($update);
                return true;
            case '/help':
                self::help($update);
                return true;
            case '/info':
                self::info($update);
                return true;
            case '/login':
                self::login($update);
                return true;
            case '/registration':
                self::registration($update);
                return true;
            case '/logout':
                self::logout($update);
                return true;
            case '/cancel':
                self::cancel($update);
                return true;
            default:
                return false;
        }
    }






    public static function cancel($update)
    {
        if (!$update->tg_chat->dealer or !$update->tg_chat->dealer->is_validated) {
            $update->tg_chat->update(["action" => null]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::empty(),
                'text' => trans('msg.cancelled'),
            ]);
        }
        if ($update->tg_chat->action === 'auction>end')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.unexpected_cancel_command_on_joined_auction', [
                    'left_btn' => trans('msg.left_btn'),
                ]),
            ]);
        if ($update->tg_chat->action === 'home>end')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('dealer'),
                'text' => trans('msg.empty_action'),
            ]);
        $update->tg_chat->update(["action" => 'home>end']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('dealer'),
            'text' => trans('msg.cancelled'),
        ]);
    }





    private static function start($update)
    {
        if (!$update->tg_chat) {
            $new_tg_chat = DealerChat::create([
                "chat_id" => $update->chat_id,
            ]);
            $new_tg_chat->update(['action' => 'start>choosing_lang']);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::chooseLang(),
                'text' => trans('msg.choose_lang'),
            ]);
        }

        if (!$update->tg_chat->dealer or !$update->tg_chat->dealer->is_validated) {
            $update->tg_chat->update(['action' => 'start>choosing_lang']);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::chooseLang(),
                'text' => trans('msg.choose_lang'),
            ]);
        }

        $update->tg_chat->update(['action' => 'home>end']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('dealer'),
            'text' => trans('msg.choose_section'),
        ]);
    }






    private static function login($update)
    {
        if ($update->tg_chat->dealer)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.already_logged_in'),
            ]);
        $update->tg_chat->update(['action' => 'start>login>waiting_contact']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::contact(),
            'text' => trans('msg.ask_contact', [
                'btn' => trans('msg.contact_btn')
            ]),
        ]);
    }




    private static function registration($update)
    {
        if ($update->tg_chat->dealer)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.already_logged_in')
            ]);
        $update->tg_chat->update(['action' => 'start>registration>waiting_contact']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::contact(),
            'text' => trans('msg.ask_contact', [
                'btn' => trans('msg.contact_btn')
            ]),
        ]);
    }




    private static function logout($update)
    {
        if (!$update->tg_chat->dealer)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.not_logged_in'),
            ]);
        if ($update->tg_chat->action === 'auction>end')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.unexpected_logout_command_on_joined_auction', [
                    'left_btn' => trans('msg.left_btn'),
                ]),
            ]);
        $update->tg_chat->update(["dealer_id" => null]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::empty(),
            'text' => trans('msg.logged_out')
        ]);
    }



    private static function info($update)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'text' => trans('msg.info'),
        ]);
    }





    private static function help($update)
    {
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'text' => trans('msg.help'),
        ]);
    }
}
