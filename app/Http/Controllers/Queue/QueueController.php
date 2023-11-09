<?php

namespace App\Http\Controllers\Queue;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Operator;
use App\Models\Queue;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class QueueController
{
    public static function make(string $operation, int $id): ?Queue
    {
        switch ($operation) {
            case 'new_car':
                $new_queue = Car::find($id)->queueable()->create([
                    'operation' => $operation,
                ]);
                break;
            case 'new_operator':
                $new_queue = Operator::find($id)->queueable()->create([
                    'operation' => $operation,
                ]);
                break;
            case 'finished_auction':
                $new_queue = Auction::find($id)->queueable()->create([
                    'operation' => $operation,
                ]);
                break;
            default:
                Log::error('Undefined operation on QueueController: ' . $operation);
                return null;
        }

        self::setQueueToOperator($new_queue);
        return $new_queue;
    }





    public static function finish(Queue $queue, string $data)
    {
        if ($data === 'ignore')
            return self::ignoreQueue($queue);

        switch ($queue->operation) {
            case 'new_car':
                self::finishNewCar($queue, $data);
                break;
            case 'new_operator':
                self::finishNewOperator($queue, $data);
                break;
            case 'finished_auction':
                self::finishFinishedAuction($queue, $data);
                break;
        }
    }




    public static function setOperatorToQueue(Operator $operator, $queue = null): ?Queue
    {
        if ($queue)
            goto end;

        $queue = Queue::where('operator_id', null)->first();

        if ($operator->queue)
            return self::ignoreQueue($operator->queue);

        if (!$queue) return null;

        end:
        switch ($queue->operation) {
            case 'new_car':
                self::newCar($operator, $queue);
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




    private static function setQueueToOperator(Queue $queue, $operator = null): ?Operator
    {
        if ($operator)
            goto end;

        $operator = Operator::where('is_validated', true)
            ->whereHas('tg_chat', fn ($query) => $query->where('action', 'home>end'))
            ->doesntHave('queue')
            ->first();

        if (!$operator) return null;


        end:
        switch ($queue->operation) {
            case 'new_car':
                self::newCar($operator, $queue);
                break;
            case 'new_operator':
                self::newOperator($operator, $queue);
                break;
            case 'finished_auction':
                self::finishedAuction($operator, $queue);
                break;
        }

        return $operator;
    }




    public static function ignoreQueue(Queue $queue): void
    {
        $operator = $queue->operator;
        $new_queue = Queue::where('operator_id', null)->first();

        if ($new_queue) {
            // * Change task from old_queue to new_queue
            Telegram::bot('operator-bot')->sendMessage([
                'chat_id' => $operator->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans(key: 'msg.queue_ignored', locale: $operator->tg_chat->lang),
            ]);
            self::setOperatorToQueue($operator, $new_queue);
            $queue->update(['operator_id' => null]);
            self::setQueueToOperator($queue);
            return;
        }

        // * If there is no new queue
        // * Try to set new free operator
        $new_operator = self::setQueueToOperator($queue);

        if ($new_operator) {
            Telegram::bot('operator-bot')->sendMessage([
                'chat_id' => $operator->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans(key: 'msg.queue_ignored', locale: $operator->tg_chat->lang),
            ]);
            return;
        }

        // * If there is no new operator
        // * Get any new operator which not free
        $new_operator = Operator::where('is_validated', true)
            ->has('tg_chat')
            ->get()
            ->except($operator->id)
            ->first();

        // * If there is no operator except current operator -> abort ignore command, resend current task
        if ($new_operator) {
            $queue->update(['operator_id' => null]);
            Telegram::bot('operator-bot')->sendMessage([
                'chat_id' => $operator->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans(key: 'msg.queue_ignored', locale: $operator->tg_chat->lang),
            ]);
            return;
        }

        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'reply_markup' => KeyboardLayout::home('operator'),
            'text' => trans('msg.cannot_cancel_queue'),
        ]);
        self::setOperatorToQueue($operator, $queue);
        return;
    }




    private static function newCar(Operator $operator, Queue $queue)
    {
        app()->setLocale($operator->tg_chat->lang);
        $car = $queue->queueable;
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
        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $operator->tg_chat->chat_id,
            'reply_markup' => KeyboardLayout::taskValidationBtns($queue),
            'text' => trans('msg.ask_validate_car_msg'),
        ]);
    }

    private static function finishNewCar(Queue $queue, $data)
    {
        $new_car = $queue->queueable;
        $owner = $new_car->user;
        $operator = $queue->operator;
        $queue->delete();

        // * Allow
        if ($data === 'allow') {
            $new_auction = $new_car->lastAuction();
            if ($operator) {
                // * Send message for Operator
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.auction_created_info', [
                        'car_id' => $new_car->id,
                        'company' => $new_car->company,
                        'model' => $new_car->model,
                        'owner' => $owner->firstname . ' ' . $owner->lastname,
                        'start' => $new_auction->getStart(),
                        'finish' => $new_auction->getFinish(),
                        'starting_price' => $new_auction->starting_price,
                    ]),
                ]);
            }

            // * Send message for Owner
            app()->setlocale($owner->tg_chat->lang);
            Telegram::bot('user-bot')->sendMessage([
                'chat_id' => $owner->tg_chat->chat_id,
                'parse_mode' => 'html',
                'text' => trans('msg.auction_created_info', [
                    'car_id' => $new_car->id,
                    'company' => $new_car->company,
                    'model' => $new_car->model,
                    'owner' => $owner->firstname . ' ' . $owner->lastname,
                    'start' => $new_auction->getStart(),
                    'finish' => $new_auction->getFinish(),
                    'starting_price' => $new_auction->starting_price,
                ]),
            ]);
        }

        // * Deny
        else {
            if ($operator) {
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_denied_for_operator'),
                ]);
            }
            app()->setlocale($new_car->user->tg_chat->lang);
            Telegram::bot('user-bot')->sendMessage([
                'chat_id' => $new_car->user->tg_chat->chat_id,
                'text' => trans('msg.request_denied'),
            ]);
            $new_car->delete();
        }

        end:
        if ($operator)
            self::setOperatorToQueue($operator);
    }





    private static function newOperator(Operator $main_operator, Queue $queue)
    {
        app()->setLocale($main_operator->tg_chat->lang);

        $new_operator = $queue->queueable;

        $queue->update(['operator_id' => $main_operator->id]);

        Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $main_operator->tg_chat->chat_id,
            'text' => trans('msg.new_task'),
        ]);
        return Telegram::bot('operator-bot')->sendMessage([
            'chat_id' => $main_operator->tg_chat->chat_id,
            'parse_mode' => 'html',
            'reply_markup' => KeyboardLayout::taskValidationBtns($queue),
            'text' => trans('msg.new_operator_confirmation', [
                'firstname' => $new_operator->firstname,
                'lastname' => $new_operator->lastname,
                'contact' => $new_operator->contact,
            ]),
        ]);
    }

    private static function finishNewOperator(Queue $queue, string $data)
    {
        $new_operator = $queue->queueable;
        $operator = $queue->operator;
        $queue->delete();

        // * Allow
        if ($data === 'allow') {
            if ($operator) {
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_allowed_for_operator'),
                ]);
            }
            $new_operator->update(["is_validated" => true]);
            if (!$new_operator->tg_chat)
                goto end;
            $new_operator->tg_chat->update(["action" => 'home>end']);
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
            self::setOperatorToQueue($new_operator);
        }

        // * Deny
        else {
            if ($operator) {
                app()->setlocale($operator->tg_chat->lang);
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'reply_markup' => KeyboardLayout::home('operator'),
                    'text' => trans('msg.request_denied_for_operator'),
                ]);
            }
            if (!$new_operator->tg_chat) {
                $new_operator->delete();
                goto end;
            }
            app()->setlocale($new_operator->tg_chat->lang);
            Telegram::bot('operator-bot')->sendMessage([
                'chat_id' => $new_operator->tg_chat->chat_id,
                'text' => trans('msg.request_denied'),
            ]);
            $new_operator->tg_chat->update(["operator_id" => null]);
            $new_operator->delete();
        }

        end:
        if ($operator)
            return self::setOperatorToQueue($operator);
    }






    private static function finishedAuction(Operator $operator, Queue $queue)
    {
        app()->setLocale($operator->tg_chat->lang);

        $auction = $queue->queueable;

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
                    'reply_markup' => KeyboardLayout::taskDoneBtns($queue),
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
                    'reply_markup' => KeyboardLayout::taskDoneBtns($queue),
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
            case 'sold_out':
                Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'text' => trans('msg.new_task'),
                ]);
                return Telegram::bot('operator-bot')->sendMessage([
                    'chat_id' => $operator->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'reply_markup' => KeyboardLayout::taskTakeBtns($queue),
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
            default:
                return;
        }
    }

    private static function finishFinishedAuction(Queue $queue, $data)
    {
        if ($data !== 'done') return;
        $operator = $queue->operator;
        $queue->delete();

        if ($operator) {
            app()->setlocale($operator->tg_chat->lang);
            Telegram::bot('operator-bot')->sendMessage([
                'chat_id' => $operator->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('operator'),
                'text' => trans('msg.task_done_msg'),
            ]);
        }

        return self::setOperatorToQueue($operator);
    }
}
