<?php

namespace App\Http\Controllers\BotController\Dealer;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Dealer;
use App\Traits\SendValidatorMessagesTrait;

class StartLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        switch ($update->action[1]) {
            case 'choosing_lang':
                self::choosingLang($update);
                return true;
            case 'authenticate':
                self::authenticate($update);
                return true;
            case 'login':
                self::login($update);
                return true;
            case 'registration':
                self::registration($update);
                return true;
            default:
                return false;
        }
    }






    private static function choosingLang($update)
    {
        if ($update->type !== 'callback_query')
            return $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);
        $update->tg_chat->update(["lang" => $update->data]);
        app()->setLocale($update->data);
        $update->tg_chat->update(['action' => 'start>authenticate']);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::contact(),
            'text' => trans('msg.ask_contact', [
                'btn' => trans('msg.contact_btn')
            ]),
        ]);
    }






    private static function authenticate($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        if ($update->type !== 'contact')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.invalid_contact', [
                    'btn' => trans('msg.contact_btn')
                ]),
            ]);
        $dealer = Dealer::where('contact', $update->data)->first();
        if ($dealer) {
            $update->tg_chat->update([
                'action' => 'home>end',
                'dealer_id' => $dealer->id,
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('dealer'),
                'text' => trans('msg.welcome_msg', [
                    'firstname' => $dealer->firstname,
                    'lastname' => $dealer->lastname,
                ]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::channelLink(),
                'text' => trans('msg.channel_link_for_dealer'),
            ]);
        }
        $update->tg_chat->update([
            'action' => 'start>registration>waiting_firstname',
            'data' => json_encode(['contact' => $update->data]),
        ]);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'text' => trans('msg.registration_started'),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_firstname'),
        ]);
    }





    private static function login($update)
    {
        if ($update->action[2] !== 'waiting_contact')
            return;
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        if ($update->type !== 'contact')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.invalid_contact', [
                    'btn' => trans('msg.contact_btn')
                ]),
            ]);
        $dealer = Dealer::where('contact', $update->data)->first();
        if (!$dealer) {
            $update->tg_chat->update(['action' => null]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::empty(),
                'text' => trans('msg.wrong_credentials'),
            ]);
        }
        $update->tg_chat->update([
            'action' => 'home>end',
            'dealer_id' => $dealer->id,
        ]);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('dealer'),
            'text' => trans('msg.welcome_msg', [
                'firstname' => $dealer->firstname,
                'lastname' => $dealer->lastname,
            ]),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::channelLink(),
            'text' => trans('msg.channel_link_for_dealer'),
        ]);
    }




    private static function registration($update)
    {
        if ($update->action[2] === 'waiting_contact') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            if ($update->type !== 'contact')
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'reply_markup' => KeyboardLayout::contact(),
                    'text' => trans('msg.invalid_contact', [
                        'btn' => trans('msg.contact_btn')
                    ]),
                ]);
            $dealer = Dealer::where('contact', $update->data)->first();
            if ($dealer)
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'text' => trans('msg.exist_contact'),
                ]);
            $update->tg_chat->update([
                'action' => 'start>registration>waiting_firstname',
                'data' => json_encode(['contact' => $update->data]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::cancel(),
                'text' => trans('msg.ask_firstname'),
            ]);
        } elseif ($update->action[2] === 'waiting_firstname') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            $data = json_decode($update->tg_chat->data);
            $data->firstname = $update->data;
            $update->tg_chat->update([
                'action' => 'start>registration>waiting_lastname',
                'data' => json_encode($data),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::cancel(),
                'text' => trans('msg.ask_lastname'),
            ]);
        } elseif ($update->action[2] === 'waiting_lastname') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            $data = json_decode($update->tg_chat->data);
            $data->lastname = $update->data;
            $new_dealer = Dealer::create([
                'contact' => $data->contact,
                'firstname' => $data->firstname,
                'lastname' => $data->lastname,
                'is_validated' => true,
            ]);
            $update->tg_chat->update([
                "dealer_id" => $new_dealer->id,
                "action" => 'home>end',
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.registered'),
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('dealer'),
                'text' => trans('msg.welcome_msg', [
                    'firstname' => $new_dealer->firstname,
                    'lastname' => $new_dealer->lastname,
                ]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::channelLink(),
                'text' => trans('msg.channel_link_for_dealer'),
            ]);
        }
    }
}
