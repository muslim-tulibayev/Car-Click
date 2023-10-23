<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Dealer;
use App\Models\Operator;
use App\Models\Queue;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class QueueController
{
    public static function make(string $operation, int $id)
    {
        switch ($operation) {
            case 'new_car':
                $queue = Queue::create([
                    "operation" => $operation,
                    "data" => $id,
                ]);
                break;
            case 'new_dealer':
                $queue = Queue::create([
                    "operation" => $operation,
                    "data" => $id,
                ]);
                break;
            case 'new_operator':
                $queue = Queue::create([
                    "operation" => $operation,
                    "data" => $id,
                ]);
                break;
            case 'finished_auction':
                $queue = Queue::create([
                    "operation" => $operation,
                    "data" => $id,
                ]);
                break;
            default:
                Log::error('Undefined operation on QueueController: ' . $operation);
                return;
        }

        $operator = Operator::where('is_validated', true)
            ->whereHas('tg_chat', fn ($query) => $query->where('action', 'home>end'))
            ->doesntHave('queue')
            ->first();

        if (!$operator)
            return $queue;

        self::setToOperator($operator);
        return $queue;
    }



    public static function setToOperator(Operator $operator)
    {
        $queue = Queue::where('operator_id', null)->first();

        if (!$queue) return;

        switch ($queue->operation) {
            case 'new_car':
                self::newCar($operator, $queue);
                break;
            case 'new_dealer':
                self::newDealer($operator, $queue);
                break;
            case 'new_operator':
                self::newOperator($operator, $queue);
                break;
            case 'finished_auction':
                self::finishedAuction($operator, $queue);
                break;
        }

        return $queue;
    }





    public static function unsetFromOperator(Operator $old_operator)
    {
        $old_queue = $old_operator->queue;
        $old_queue->update(['operator_id' => null]);
        $new_operator = Operator::where('is_validated', true)
            ->where('id', '!=', $old_operator->id)
            ->whereHas('tg_chat', fn ($query) => $query->where('action', 'home>end'))
            ->doesntHave('queue')
            ->first();
        if ($new_operator)
            switch ($old_queue->operation) {
                case 'new_car':
                    self::newCar($new_operator, $old_queue);
                    break;
                case 'new_dealer':
                    self::newDealer($new_operator, $old_queue);
                    break;
                case 'new_operator':
                    self::newOperator($new_operator, $old_queue);
                    break;
                case 'finished_auction':
                    self::finishedAuction($new_operator, $old_queue);
                    break;
            }

        $new_queue = Queue::where('operator_id', null)
            ->where('id', '!=', $old_queue->id)
            ->first();
        if ($new_queue)
            switch ($new_queue->operation) {
                case 'new_car':
                    self::newCar($old_operator, $new_queue);
                    break;
                case 'new_dealer':
                    self::newDealer($old_operator, $new_queue);
                    break;
                case 'new_operator':
                    self::newOperator($old_operator, $new_queue);
                    break;
                case 'finished_auction':
                    self::finishedAuction($old_operator, $new_queue);
                    break;
            }
    }






    private static function newCar(Operator $operator, Queue $queue)
    {
        app()->setLocale($operator->tg_chat->lang);

        $car = Car::find($queue->data);

        if (!$car)
            return $queue->delete();

        $queue->update(['operator_id' => $operator->id]);

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

        return Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'reply_markup' => KeyboardLayout::validateCar($car->id),
            'text' => trans('msg.ask_validate_car_msg'),
        ]);
    }






    private static function newDealer(Operator $operator, Queue $queue)
    {
        app()->setLocale($operator->tg_chat->lang);

        $dealer = Dealer::find($queue->data);

        if (!$dealer)
            return $queue->delete();

        $queue->update(['operator_id' => $operator->id]);

        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        return Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::validateDealer($dealer->id),
            'text' => trans('msg.new_dealer_confirmation', [
                'firstname' => $dealer->firstname,
                'lastname' => $dealer->lastname,
                'contact' => $dealer->contact,
            ]),
        ]);
    }





    private static function newOperator(Operator $main_operator, Queue $queue)
    {
        app()->setLocale($main_operator->tg_chat->lang);

        $new_operator = Operator::find($queue->data);

        if (!$new_operator)
            return $queue->delete();

        $queue->update(['operator_id' => $main_operator->id]);

        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $main_operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        return Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $main_operator->tg_chat->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::validateOperator($new_operator->id),
            'text' => trans('msg.new_operator_confirmation', [
                'firstname' => $new_operator->firstname,
                'lastname' => $new_operator->lastname,
                'contact' => $new_operator->contact,
            ]),
        ]);
    }






    private static function finishedAuction(Operator $operator, Queue $queue)
    {
        app()->setLocale($operator->tg_chat->lang);

        $auction = Auction::find($queue->data);

        if (!$auction) return $queue->delete();

        $queue->update(['operator_id' => $operator->id]);

        switch ($auction->car->status) {
            case 'not_sold':
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'text' => trans('msg.new_task'),
                ]);
                return Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::askTaskDone(),
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
            case 'didnt_sell':
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'text' => trans('msg.new_task'),
                ]);
                return Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::askTaskDone(),
                    'text' => trans('msg.didnt_sell_message_for_operator', [
                        'owner_fname' => $auction->car->user->firstname,
                        'owner_lname' => $auction->car->user->lastname,
                        'owner_phone' => $auction->car->user->contact,
                        'car_id' => $auction->car->id,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                        'highest_price' => $auction->highest_price,
                    ]),
                ]);
            case 'sold_out':
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'text' => trans('msg.new_task'),
                ]);
                return Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::askTaskDone(),
                    'text' => trans('msg.car_sold_message_for_operator', [
                        'car_id' => $auction->car->id,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                        'highest_price' => $auction->highest_price,
                        'winner_fname' => $auction->highestPriceOwner->firstname,
                        'winner_lname' => $auction->highestPriceOwner->lastname,
                        'winner_phone' => $auction->highestPriceOwner->contact,
                        'owner_fname' => $auction->car->user->firstname,
                        'owner_lname' => $auction->car->user->lastname,
                        'owner_phone' => $auction->car->user->contact,
                    ]),
                ]);
            default:
                return;
        }
    }
}
