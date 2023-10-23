<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Operator;
use App\Traits\SendValidatorMessagesTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        $operator = Operator::where('contact', $update->data)->first();

        if ($operator) {
            $update->tg_chat->update([
                'action' => 'start>login>waiting_password',
                'data' => json_encode(['contact' => $update->data]),
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.login_started'),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::cancel(),
                'text' => trans('msg.ask_password'),
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
        if ($update->action[2] === 'waiting_contact') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            if ($update->type !== 'contact')
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'text' => trans('msg.invalid_contact', [
                        'btn' => trans('msg.contact_btn')
                    ]),
                ]);
            $update->tg_chat->update([
                'action' => 'start>login>waiting_password',
                'data' => json_encode(['contact' => $update->data]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::cancel(),
                'text' => trans('msg.ask_password'),
            ]);
        } elseif ($update->action[2] === 'waiting_password') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            $data = json_decode($update->tg_chat->data);
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);
            $data->password = $update->data;
            $operator = Operator::where('contact', $data->contact)->first();
            if (!$operator || !Hash::check($data->password, $operator->password)) {
                $update->tg_chat->update(['action' => null]);
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'reply_markup' => KeyboardLayout::empty(),
                    'text' => trans('msg.wrong_credentials'),
                ]);
            }
            if (!$operator->is_validated) {
                $update->tg_chat->update([
                    'action' => null,
                    'operator_id' => $operator->id,
                ]);
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'reply_markup' => KeyboardLayout::empty(),
                    'text' => trans('msg.not_validated_account', [
                        'firstname' => $operator->firstname,
                        'lastname' => $operator->lastname,
                    ]),
                ]);
            }
            $update->tg_chat->update([
                'action' => 'home>end',
                'operator_id' => $operator->id,
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.welcome_msg', [
                    'firstname' => $operator->firstname,
                    'lastname' => $operator->lastname,
                ]),
            ]);
            return QueueController::setToOperator($operator);
        }
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
            $operator = Operator::where('contact', $update->data)->first();
            if ($operator)
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
            $update->tg_chat->update([
                'action' => 'start>registration>waiting_password',
                'data' => json_encode($data),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::cancel(),
                'text' => trans('msg.ask_new_password'),
            ]);
        } elseif ($update->action[2] === 'waiting_password') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            $validator = Validator::make(
                ["password" => $update->data],
                ["password" => 'string|min:8']
            );
            if ($validator->fails())
                return self::sendValidatorMessages($validator, $update);
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);
            $data = json_decode($update->tg_chat->data);
            $data->password = $update->data;
            $new_operator = Operator::create([
                'contact' => $data->contact,
                'firstname' => $data->firstname,
                'lastname' => $data->lastname,
                'password' => Hash::make($data->password),
            ]);
            $update->tg_chat->update([
                "operator_id" => $new_operator->id,
                "action" => null,
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::empty(),
                'text' => trans('msg.request_registered_msg'),
            ]);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::empty(),
                'text' => trans('msg.please_wait'),
            ]);

            return QueueController::make('new_operator', $new_operator->id);
        }
    }
}
