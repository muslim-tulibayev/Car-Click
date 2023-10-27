<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\Auction\AuctionController;
use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Traits\SendValidatorMessagesTrait;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Laravel\Facades\Telegram;

class OperationLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        // * Gate
        if (!$update->tg_chat->operator) return;
        if (!$update->tg_chat->operator->queue) return;
        if (!$update->tg_chat->operator->is_validated) return;

        switch ($update->action[1]) {
            case 'validate_car':
                self::validateCar($update);
                return true;
            default:
                return false;
        }
    }





    private static function validateCar($update)
    {
        if ($update->action[2] === 'waiting_auction_start') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);
            // * Check for btns
            if ($update->data === trans('msg.now_btn')) {
                $start = new DateTime(timezone: new DateTimeZone('GMT+5'));
                goto finish;
            }
            if ($update->data === trans('msg.after_30_mins_btn')) {
                $start = new DateTime(timezone: new DateTimeZone('GMT+5'));
                $start->modify('+30 minutes');
                goto finish;
            }
            if ($update->data === trans('msg.after_1_h_btn')) {
                $start = new DateTime(timezone: new DateTimeZone('GMT+5'));
                $start->modify('+1 hour');
                goto finish;
            }
            if ($update->data === trans('msg.after_2_hs_btn')) {
                $start = new DateTime(timezone: new DateTimeZone('GMT+5'));
                $start->modify('+2 hours');
                goto finish;
            }
            // * Check for clock's and date
            $validator = Validator::make(
                ["start" => $update->data],
                ["start" => 'date_format:H:i'],
            );
            if ($validator->fails()) {
                $validator = Validator::make(
                    ["start" => $update->data],
                    ["start" => 'date_format:Y-m-d H:i'],
                );
                if ($validator->fails())
                    return $update->bot->sendMessage([
                        'chat_id' => $update->chat_id,
                        'text' => trans('msg.invalid_start'),
                    ]);
                $validator = Validator::make(
                    ["start" => $update->data],
                    ["start" => 'after:' . now('GMT+5')->format('Y-m-d H:i')],
                );
                if ($validator->fails())
                    return self::sendValidatorMessages($validator, $update);
                $start = new DateTime($update->data, new DateTimeZone('GMT+5'));
                goto finish;
            }
            $validator = Validator::make(
                ["start" => $update->data],
                ["start" => 'after:' . now('GMT+5')->format('H:i')],
            );
            if ($validator->fails())
                return self::sendValidatorMessages($validator, $update);
            $start = new DateTime(now('GMT+5')->format('Y-m-d') . $update->data, new DateTimeZone('GMT+5'));
            finish:
            $data = json_decode($update->tg_chat->data);
            $data->start = $start->format('Y-m-d H:i:s');
            $update->tg_chat->update([
                'action' => 'operation>validate_car>waiting_auction_starting_price',
                'data' => json_encode($data),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::cancel(),
                'text' => trans('msg.ask_starting_price'),
            ]);
        } elseif ($update->action[2] === 'waiting_auction_starting_price') {
            if ($update->data === trans('msg.cancel_btn'))
                return Command::cancel($update);

            $update->data = str_replace('$', '', $update->data);
            $update->data = str_replace(' ', '', $update->data);
            $update->data = str_replace(',', '', $update->data);

            $validator = Validator::make(
                ["starting_price" => $update->data],
                ["starting_price" => 'integer|min:0'],
            );
            if ($validator->fails())
                return self::sendValidatorMessages($validator, $update);
            $data = json_decode($update->tg_chat->data);
            $data->starting_price = $update->data;

            // * Broadcast
            $new_auction = AuctionController::broadcast($data);

            // * Send message for Owner
            app()->setlocale($new_auction->car->user->tg_chat->lang);
            Telegram::bot('user-bot')->sendMessage([
                'chat_id' => $new_auction->car->user->tg_chat->chat_id,
                'parse_mode' => 'html',
                'text' => trans('msg.auction_created_info', [
                    'car_id' => $new_auction->car->id,
                    'company' => $new_auction->car->company,
                    'model' => $new_auction->car->model,
                    'owner' => $new_auction->car->user->firstname . ' ' . $new_auction->car->user->lastname,
                    'start' => $new_auction->getStart(),
                    'finish' => $new_auction->getFinish(),
                    'starting_price' => $new_auction->starting_price,
                ]),
            ]);

            // * Send message for Operator
            app()->setlocale($update->tg_chat->lang);
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'parse_mode' => 'html',
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.auction_created_info', [
                    'car_id' => $new_auction->car->id,
                    'company' => $new_auction->car->company,
                    'model' => $new_auction->car->model,
                    'owner' => $new_auction->car->user->firstname . ' ' . $new_auction->car->user->lastname,
                    'start' => $new_auction->getStart(),
                    'finish' => $new_auction->getFinish(),
                    'starting_price' => $new_auction->starting_price,
                ]),
            ]);

            if ($update->tg_chat->operator->queue) {
                $update->tg_chat->operator->queue->delete();
                QueueController::setToOperator($update->tg_chat->operator);
            }
            return $update->tg_chat->update(['action' => 'home>end']);
        }
    }
}
