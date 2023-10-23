<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Operator;
use App\Models\OperatorChat;
use Illuminate\Support\Facades\Log;

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
            case '/task':
                self::getTask($update);
                return true;
            default:
                return false;
        }
    }





    private static function getTask($update)
    {
        if (!$update->tg_chat->operator) return;
        if (!$update->tg_chat->operator->is_validated) return;
        if ($update->tg_chat->action !== 'home>end') return;
        if ($update->tg_chat->operator->queue) return;

        if (!QueueController::setToOperator($update->tg_chat->operator))
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::empty(),
                'text' => trans('msg.empty_queue'),
            ]);
    }







    public static function cancel($update)
    {
        $operator = $update->tg_chat->operator;
        $operation = $update->tg_chat->action;
        // todo: another msg for cancel queue

        // * No operator and Not validated
        if (!$operator or !$operator->is_validated) {
            // * No operation
            if (!$operation)
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'reply_markup' => KeyboardLayout::empty(),
                    'text' => trans('msg.empty_action'),
                ]);
            $update->tg_chat->update(["action" => null]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::empty(),
                'text' => trans('msg.cancelled'),
            ]);
        }

        // * No queue:
        // *    No operation
        if (!$operator->queue and $operation === 'home>end') {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.empty_action'),
            ]);
            return QueueController::setToOperator($operator);
        }


        // *    Has an operation
        if (!$operator->queue and $operation !== 'home>end') {
            $update->tg_chat->update(["action" => 'home>end']);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.cancelled'),
            ]);
            return QueueController::setToOperator($operator);
        }

        // * Has queue
        // *    Has queue but no operation
        if ($operator->queue and $operation === 'home>end')
            goto doing_the_operation;

        // *    Has another operation (which doesn't belong to the current queue)
        if ($operator->queue and explode('>', $operation)[0] !== 'operation') {
            $update->tg_chat->update(["action" => 'home>end']);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.cancelled'),
            ]);
        }

        // *    Doing the operation
        if ($operator->queue and explode('>', $operation)[0] === 'operation') {
            doing_the_operation:
            // * If opertors count is only 1 -> 'Abort'
            if (Operator::where('is_validated', true)->count() === 1)
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'text' => trans('msg.cannot_cancel_queue'),
                ]);

            $update->tg_chat->update(["action" => 'home>end']);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.cancelled'),
            ]);
            return QueueController::unsetFromOperator($operator);
        }
    }





    private static function start($update)
    {
        if (!$update->tg_chat) {
            $new_tg_chat = OperatorChat::create([
                "chat_id" => $update->chat_id,
            ]);
            $new_tg_chat->update(['action' => 'start>choosing_lang']);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::chooseLang(),
                'text' => trans('msg.choose_lang'),
            ]);
        }
        if (!$update->tg_chat->operator or !$update->tg_chat->operator->is_validated) {
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
            'reply_markup' => KeyboardLayout::home('operator'),
            'text' => trans('msg.choose_section'),
        ]);
    }






    private static function login($update)
    {
        if ($update->tg_chat->operator)
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
        if ($update->tg_chat->operator)
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
        $operator = $update->tg_chat->operator;

        if (!$operator)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.not_logged_in'),
            ]);

        // *    Doing the operation
        if ($operator->queue) {
            // * If opertors count is only 1 -> 'Abort'
            if (Operator::where('is_validated', true)->count() === 1)
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'text' => trans('msg.cannot_logout_because_of_queue'),
                ]);
            QueueController::unsetFromOperator($operator);
        }

        $update->tg_chat->update([
            "operator_id" => null,
            "action" => null,
        ]);
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
