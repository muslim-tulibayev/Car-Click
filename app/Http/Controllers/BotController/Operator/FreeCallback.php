<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Car;
use App\Models\Dealer;
use App\Models\Operator;
use Telegram\Bot\Laravel\Facades\Telegram;

class FreeCallback
{
    public static function handle($update)
    {
        if ($update->type !== 'callback_query')
            return false;

        $data = explode(':', $update->data);

        if ($data[0] !== 'task|ignore')
            // * Remove each callbacks here first
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);

        // $update->bot->editMessageReplyMarkup([
        //     'chat_id' => $update->chat_id,
        //     'message_id' => $update->message_id,
        //     'reply_markup' => KeyboardLayout::emptyInline(),
        // ]);

        switch ($data[0]) {
            case 'validate_operator|allow|operator_id':
                self::validateOperator($update, $data);
                return true;
            case 'validate_operator|deny|operator_id':
                self::validateOperator($update, $data);
                return true;
            case 'validate_dealer|allow|dealer_id':
                self::validateDealer($update, $data);
                return true;
            case 'validate_dealer|deny|dealer_id':
                self::validateDealer($update, $data);
                return true;
            case 'validate_car|allow|car_id':
                self::validateCar($update, $data);
                return true;
            case 'validate_car|deny|car_id':
                self::validateCar($update, $data);
                return true;
            case 'finished_auction|done':
                self::taskDone($update);
                return true;
            case 'task|ignore':
                self::taskIgnore($update);
                return true;
            default:
                return false;
        }
    }






    private static function validateOperator($update, $data)
    {
        if (!$update->tg_chat->operator->queue) return;
        $update->tg_chat->operator->queue->delete();
        $new_operator = Operator::where('is_validated', false)->find($data[1]);
        if (!$new_operator) goto finish;
        // * validate_operator|allow|operator_id
        if ($data[0] === 'validate_operator|allow|operator_id') {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.request_allowed_for_operator'),
            ]);
            $new_operator->update(["is_validated" => true]);
            if (!$new_operator->tg_chat)
                goto finish;
            $new_operator->tg_chat->update(["action" => 'home>end']);
            app()->setlocale($new_operator->tg_chat->lang);
            $update->bot->sendMessage([
                'chat_id' => $new_operator->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.request_allowed'),
            ]);
            $update->bot->sendMessage([
                'chat_id' => $new_operator->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.welcome_msg', [
                    'firstname' => $new_operator->firstname,
                    'lastname' => $new_operator->lastname,
                ]),
            ]);
            QueueController::setToOperator($new_operator);
        }
        // * validate_operator|deny|operator_id 
        else {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.request_denied_for_operator'),
            ]);
            if (!$new_operator->tg_chat) {
                $new_operator->delete();
                goto finish;
            }
            app()->setlocale($new_operator->tg_chat->lang);
            $update->bot->sendMessage([
                'chat_id' => $new_operator->tg_chat->chat_id,
                'text' => trans('msg.request_denied'),
            ]);
            $new_operator->tg_chat->update(["operator_id" => null]);
            $new_operator->delete();
        }
        finish:
        return QueueController::setToOperator($update->tg_chat->operator);
    }






    private static function validateDealer($update, $data)
    {
        if (!$update->tg_chat->operator->queue) return;
        $update->tg_chat->operator->queue->delete();
        $dealer = Dealer::where('is_validated', false)->find($data[1]);
        if (!$dealer) goto finish;
        // * validate_dealer|allow|dealer_id
        if ($data[0] === 'validate_dealer|allow|dealer_id') {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.request_allowed_for_operator'),
            ]);
            $dealer->update(["is_validated" => true]);
            if (!$dealer->tg_chat)
                goto finish;
            $dealer->tg_chat->update(["action" => 'home>end']);
            app()->setlocale($dealer->tg_chat->lang);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'text' => trans('msg.request_allowed'),
            ]);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('dealer'),
                'text' => trans('msg.welcome_msg', [
                    'firstname' => $dealer->firstname,
                    'lastname' => $dealer->lastname,
                ]),
            ]);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::channelLink(),
                'text' => trans('msg.channel_link_for_dealer'),
            ]);
        }
        // * validate_dealer|deny|dealer_id 
        else {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.request_denied_for_operator'),
            ]);
            if (!$dealer->tg_chat) {
                $dealer->delete();
                goto finish;
            }
            app()->setlocale($dealer->tg_chat->lang);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'text' => trans('msg.request_denied'),
            ]);
            $dealer->tg_chat->update(["dealer_id" => null]);
            $dealer->delete();
        }
        finish:
        return QueueController::setToOperator($update->tg_chat->operator);
    }







    private static function validateCar($update, $data)
    {
        if (!$update->tg_chat->operator->queue) return;
        $car = Car::find($data[1]);
        if (!$car) goto finish;
        // * validate_car|allow|car_id
        if ($data[0] === 'validate_car|allow|car_id') {
            $update->tg_chat->update([
                'action' => 'operation>validate_car>waiting_auction_start',
                'data' => json_encode(['car_id' => $car->id]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'parse_mode' => 'html',
                'reply_markup' => KeyboardLayout::askStart(),
                'text' => trans('msg.ask_start'),
            ]);
        }
        // * validate_car|deny|car_id
        else {
            $update->tg_chat->operator->queue->delete();
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.request_denied_for_operator'),
            ]);
            app()->setlocale($car->user->tg_chat->lang);
            Telegram::bot('user-bot')->sendMessage([
                'chat_id' => $car->user->tg_chat->chat_id,
                'text' => trans('msg.request_denied'),
            ]);
            $car->delete();
        }
        finish:
        return QueueController::setToOperator($update->tg_chat->operator);
    }





    private static function taskDone($update)
    {
        if (!$update->tg_chat->operator->queue) return;
        $update->tg_chat->operator->queue->delete();
        return QueueController::setToOperator($update->tg_chat->operator);
    }





    private static function taskIgnore($update)
    {
        if (!$update->tg_chat->operator->queue) return;

        // * If opertors count is only 1 -> 'Abort'
        if (Operator::where('is_validated', true)->count() === 1)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.cannot_cancel_queue'),
            ]);

        $update->bot->deleteMessage([
            'chat_id' => $update->chat_id,
            'message_id' => $update->message_id,
        ]);

        $update->tg_chat->update(["action" => 'home>end']);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('operator'),
            'text' => trans('msg.cancelled'),
        ]);
        return QueueController::unsetFromOperator($update->tg_chat->operator);
    }
}


// // for ($i = $update->message_id - count($car->images); $i < $update->message_id; $i++)
// //     $update->bot->deleteMessage([
// //         'chat_id' => $update->chat_id,
// //         'message_id' => $i,
// //     ]);