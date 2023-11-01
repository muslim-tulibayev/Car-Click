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
            AuctionController::broadcast($data);

            QueueController::finish($update->tg_chat->operator->queue, 'allow');

            return $update->tg_chat->update(['action' => 'home>end']);
        }
    }
}
