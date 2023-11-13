<?php

namespace App\Http\Controllers\BotController\Message;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\BotController\Operator\BidLayer;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Operator;
use App\Models\Task;
use Telegram\Bot\Laravel\Facades\Telegram;

class MessageLayout
{
    public static function taskNtfyNewCar(Operator $operator, Car $car): int
    {
        app()->setLocale($operator->tg_chat->lang);
        $album = [];
        foreach ($car->images as $image)
            $album[] = [
                'type' => 'photo',
                'media' => $image->file_id,
            ];
        $album[0]['caption'] = trans('msg.car_added_info', [
            'id' => $car->id,
            'company' => $car->company,
            'model' => $car->model,
            'year' => $car->year,
            'color' => $car->color,
            'condition' => trans('msg.' . $car->condition),
            'additional' => $car->additional,
        ]);
        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        Telegram::bot('operator-bot')->sendMediaGroup([
            'chat_id' => $operator->tg_chat->chat_id,
            'media' => json_encode($album),
        ]);
        $response = Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'reply_markup' => KeyboardLayout::taskNtfyBtns($car->taskable),
            'text' => trans('msg.ask_validate_car_msg'),
        ]);

        return $response->message_id;
    }



    public static function taskNtfyNewOperator(Operator $operator, Operator $new_operator): int
    {
        app()->setLocale($operator->tg_chat->lang);
        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        $response = Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::taskNtfyBtns($new_operator->taskable),
            'text' => trans('msg.new_operator_confirmation', [
                'firstname' => $new_operator->firstname,
                'lastname' => $new_operator->lastname,
                'contact' => $new_operator->contact,
            ]),
        ]);

        return $response->message_id;
    }


    public static function taskNtfyFnshdAuction(Operator $operator, Auction $auction): int
    {
        app()->setLocale($operator->tg_chat->lang);

        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);

        switch ($auction->car->status) {
            case 'not_sold':
                $response = Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::taskNtfyBtns($auction->taskable),
                    'text' => trans('msg.car_not_sold_message_for_operator', [
                        'owner_fname' => $auction->car->user->firstname,
                        'owner_lname' => $auction->car->user->lastname,
                        'owner_phone' => $auction->car->user->contact,
                        'car_id' => $auction->car->id,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                    ]),
                ]);
                return $response->message_id;
            case 'didnt_sell':
                $response = Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::taskNtfyBtns($auction->taskable),
                    'text' => trans('msg.didnt_sell_message_for_operator', [
                        'owner_fname' => $auction->car->user->firstname,
                        'owner_lname' => $auction->car->user->lastname,
                        'owner_phone' => $auction->car->user->contact,
                        'car_id' => $auction->car->id,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                        'highest_price' => $auction->highestPrice(),
                    ]),
                ]);
                return $response->message_id;
            case 'sold_out':
                $response = Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::taskNtfyBtns($auction->taskable),
                    'text' => trans('msg.car_sold_message_for_operator', [
                        'car_id' => $auction->car->id,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                        'highest_price' => $auction->highestPrice(),
                        'winner_fname' => $auction->highestPriceOwner()->firstname,
                        'winner_lname' => $auction->highestPriceOwner()->lastname,
                        'winner_phone' => $auction->highestPriceOwner()->contact,
                        'owner_fname' => $auction->car->user->firstname,
                        'owner_lname' => $auction->car->user->lastname,
                        'owner_phone' => $auction->car->user->contact,
                    ]),
                ]);
                return $response->message_id;
        }
    }


    public static function taskRmMsg(Task $task, Operator $operator, int $msg_id): void
    {
        switch ($task->operation) {
            case 'new_car':
                $len = count($task->taskable->images);
                break;
            default:
                $len = 0;
                break;
        }

        for ($i = 0; $i <= $len + 1; $i++)
            Telegram::bot('operator-bot')->deleteMessage([
                'chat_id' => $operator->tg_chat->chat_id,
                'message_id' => $msg_id - $i,
            ]);
    }



    public static function taskRmAllMsgs(Task $task): void
    {
        switch ($task->operation) {
            case 'new_car':
                $len = count($task->taskable->images);
                break;
            default:
                $len = 0;
                break;
        }

        foreach ($task->messages as $msg)
            for ($i = 0; $i <= $len + 1; $i++)
                Telegram::bot('operator-bot')->deleteMessage([
                    'chat_id' => $msg->operator->tg_chat->chat_id,
                    'message_id' => $msg->msg_id - $i,
                ]);
    }




    public static function taskRmAnsweredMsg(Task $task, $update): void
    {
        switch ($task->operation) {
            case 'new_car':
                $len = count($task->taskable->images);
                break;
            default:
                $len = 0;
                break;
        }

        for ($i = 0; $i <= $len + 1; $i++)
            Telegram::bot('operator-bot')->deleteMessage([
                'chat_id' => $task->operator->tg_chat->chat_id,
                'message_id' => $update->message_id - $i,
            ]);
    }





    public static function taskNewCar(Operator $operator, Car $car): int
    {
        app()->setLocale($operator->tg_chat->lang);
        $album = [];
        foreach ($car->images as $image)
            $album[] = [
                'type' => 'photo',
                'media' => $image->file_id,
            ];
        $album[0]['caption'] = trans('msg.car_added_info', [
            'id' => $car->id,
            'company' => $car->company,
            'model' => $car->model,
            'year' => $car->year,
            'color' => $car->color,
            'condition' => trans('msg.' . $car->condition),
            'additional' => $car->additional,
        ]);
        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        Telegram::bot('operator-bot')->sendMediaGroup([
            'chat_id' => $operator->tg_chat->chat_id,
            'media' => json_encode($album),
        ]);
        $response = Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'reply_markup' => KeyboardLayout::taskValidationBtns($car->taskable),
            'text' => trans('msg.ask_validate_car_msg'),
        ]);

        return $response->message_id;
    }



    public static function taskNewOperator(Operator $operator, Operator $new_operator): int
    {
        app()->setLocale($operator->tg_chat->lang);
        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        $response = Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::taskValidationBtns($new_operator->taskable),
            'text' => trans('msg.new_operator_confirmation', [
                'firstname' => $new_operator->firstname,
                'lastname' => $new_operator->lastname,
                'contact' => $new_operator->contact,
            ]),
        ]);

        return $response->message_id;
    }


    public static function taskFnshdAuction(Operator $operator, Auction $auction): void
    {
        BidLayer::getList($operator, $auction);
    }




    public static function answerCallbackQuery($update, $msg)
    {
        $update->bot->answerCallbackQuery([
            'callback_query_id' => $update->callback_query_id,
            'text' => $msg,
            'show_alert' => true,
        ]);
    }




    public static function auctionAskStart($chat_id)
    {
        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::askStart(),
            'text' => trans('msg.ask_start'),
        ]);
    }





    public static function taskFnshNewCar(Task $task, string $data)
    {
        $car = $task->taskable;
        $owner = $car->user;
        $operator = $task->operator;

        // * Allow
        if ($data === 'allow') {
            $new_auction = $car->lastAuction();
            if ($operator) {
                // * Send message for Operator
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'text' => trans('msg.auction_created_info', [
                        'car_id' => $car->id,
                        'company' => $car->company,
                        'model' => $car->model,
                        'owner' => $owner->firstname . ' ' . $owner->lastname,
                        'start' => $new_auction->getStart(),
                        'finish' => $new_auction->getFinish(),
                        'starting_price' => $new_auction->starting_price,
                    ]),
                ]);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_allowed_for_operator'),
                ]);
            }

            // * Send message for Owner
            app()->setlocale($owner->tg_chat->lang);
            Telegram::bot('user-bot')->sendMessage([
                'chat_id' => $owner->tg_chat->chat_id,
                'parse_mode' => 'html',
                'text' => trans('msg.auction_created_info', [
                    'car_id' => $car->id,
                    'company' => $car->company,
                    'model' => $car->model,
                    'owner' => $owner->firstname . ' ' . $owner->lastname,
                    'start' => $new_auction->getStart(),
                    'finish' => $new_auction->getFinish(),
                    'starting_price' => $new_auction->starting_price,
                ]),
            ]);
            Telegram::bot('operator-bot')->sendMessage([
                'chat_id' => $operator->tg_chat->chat_id,
                'parse_mode' => 'html',
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.request_allowed'),
            ]);
        }

        // * Deny
        else {
            if ($operator) {
                // * Send message for Operator
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_denied_for_operator'),
                ]);
            }
            // * Send message for Owner
            app()->setlocale($car->user->tg_chat->lang);
            Telegram::bot('user-bot')->sendMessage([
                'chat_id' => $car->user->tg_chat->chat_id,
                'text' => trans('msg.request_denied'),
            ]);
        }
    }






    public static function taskFnshNewOperator(Task $task, string $data)
    {
        $operator = $task->operator;
        $new_operator = $task->taskable;

        // * Allow
        if ($data === 'allow') {
            if ($operator) {
                // * Send message to Operator
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_allowed_for_operator'),
                ]);
            }
            if ($new_operator->tg_chat) {
                // * Send message to New operator
                app()->setlocale($new_operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $new_operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_allowed'),
                ]);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $new_operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.welcome_msg', [
                        'firstname' => $new_operator->firstname,
                        'lastname' => $new_operator->lastname,
                    ]),
                ]);
            }
        }

        // * Deny
        else {
            if ($operator) {
                // * Send message to Operator
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_denied_for_operator'),
                ]);
            }
            if ($new_operator->tg_chat) {
                // * Send message to Denied operator
                app()->setlocale($new_operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $new_operator->tg_chat->chat_id,
                    'text' => trans('msg.request_denied'),
                ]);
            }
        }
    }





    public static function taskFnshFnshdAuction(Task $task, $data)
    {
        $operator = $task->operator;

        if ($data === 'done')
            if ($operator) {
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.task_done_msg'),
                ]);
            }
    }
}

































/*
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
*/