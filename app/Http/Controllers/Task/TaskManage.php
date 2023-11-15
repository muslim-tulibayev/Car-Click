<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\BotController\Message\MessageLayout;
use App\Models\Auction;
use App\Models\Car;
use App\Models\Operator;
use App\Models\Task;

class TaskManage
{
    // * Making
    public static function make(string $operation, int $id): ?Task
    {
        return self::notifyTask($operation, $id);
    }




    // * Notifying
    private static function notifyTask(string $operation, int $id): ?Task
    {
        $operators = Operator::where('is_validated', true)
            ->where('is_muted', false)
            ->has('tg_chat')
            ->get();
        switch ($operation) {
            case 'new_car':
                $new_task = Car::find($id)->taskable()->create([
                    'operation' => $operation,
                ]);
                self::ntfyNewCar($operators, $new_task);
                return $new_task;
            case 'new_operator':
                $new_task = Operator::find($id)->taskable()->create([
                    'operation' => $operation,
                ]);
                self::ntfyNewOperator($operators, $new_task);
                return $new_task;
            case 'finished_auction':
                $new_task = Auction::find($id)->taskable()->create([
                    'operation' => $operation,
                ]);
                self::ntfyFnshdAuction($operators, $new_task);
                return $new_task;
            default:
                return null;
        }
    }

    private static function ntfyNewCar($operators, Task $task)
    {
        foreach ($operators as $operator) {
            $msg_id = MessageLayout::taskNtfyNewCar($operator, $task->taskable);
            $task->messages()->create([
                'msg_id' => $msg_id,
                'operator_id' => $operator->id,
            ]);
        }
    }

    private static function ntfyNewOperator($operators, Task $task)
    {
        foreach ($operators as $operator) {
            $msg_id = MessageLayout::taskNtfyNewOperator($operator, $task->taskable);
            $task->messages()->create([
                'msg_id' => $msg_id,
                'operator_id' => $operator->id,
            ]);
        }
    }

    private static function ntfyFnshdAuction($operators, Task $task)
    {
        foreach ($operators as $operator) {
            $msg_id = MessageLayout::taskNtfyFnshdAuction($operator, $task->taskable);
            $task->messages()->create([
                'msg_id' => $msg_id,
                'operator_id' => $operator->id,
            ]);
        }
    }






    // * Removing
    public static function remove(Task $task, Operator $operator): void
    {
        $msg = $task->messages()
            ->where('operator_id', $operator->id)
            ->first();
        if (!$msg) return;
        MessageLayout::taskRmMsg($task, $operator, $msg);
    }






    // * Taking
    public static function take(Task $task, Operator $operator): void
    {
        $task->update([
            'operator_id' => $operator->id
        ]);
        $operator->tg_chat->update([
            "action" => 'task>waiting_ans',
            "data" => $task->id,
        ]);
        switch ($task->operation) {
            case 'new_car':
                MessageLayout::taskNewCar($operator, $task->taskable);
                break;
            case 'new_operator':
                MessageLayout::taskNewOperator($operator, $task->taskable);
                break;
            case 'finished_auction':
                MessageLayout::taskFnshdAuction($operator, $task->taskable);
                break;
        }
        MessageLayout::taskRmAllMsgs($task);
    }





    // * Working on
    public static function workOn(Task $task, string $data)
    {
        $tg_chat = $task->operator->tg_chat;
        if ($task->operation === "new_car" and $data === 'allow') {
            $tg_chat->update([
                'action' => 'operation>validate_car>waiting_auction_start',
                'data' => json_encode(['car_id' => $task->taskable->id]),
            ]);
            return MessageLayout::auctionAskStart($tg_chat->chat_id);
        }
        return self::finish($task, $data);
    }





    // * Finishing
    public static function finish(Task $task, string $data)
    {
        switch ($task->operation) {
            case 'new_car':
                self::finishNewCar($task, $data);
                break;
            case 'new_operator':
                self::finishNewOperator($task, $data);
                break;
            case 'finished_auction':
                self::finishFnshdAuction($task, $data);
                break;
        }
        $task->operator->tg_chat->update(['action' => 'home>end']);
        $task->update(['is_done' => true]);
    }

    private static function finishNewCar(Task $task, $data)
    {
        MessageLayout::taskFnshNewCar($task, $data);
        if ($data !== 'allow')
            $task->taskable->delete();
    }

    private static function finishNewOperator(Task $task, string $data)
    {
        $new_operator = $task->taskable;
        MessageLayout::taskFnshNewOperator($task, $data);
        // * Allow
        if ($data === 'allow') {
            $new_operator->update(["is_validated" => true]);
            if ($new_operator->tg_chat)
                $new_operator->tg_chat->update(["action" => 'home>end']);
        }
        // * Deny
        else {
            if ($new_operator->tg_chat)
                $new_operator->tg_chat->update(["operator_id" => null]);
            $new_operator->delete();
        }
    }

    private static function finishFnshdAuction(Task $task, $data)
    {
        MessageLayout::taskFnshFnshdAuction($task, $data);
    }




    // * Getting all available tasks
    public static function availableTasks(Operator $operator)
    {
        $tasks = Task::where('is_done', false)
            ->where('operator_id', null)
            ->get();

        if (!count($tasks))
            return MessageLayout::emptyTask($operator);

        foreach ($tasks as $task) {
            $msg = $task->messages()->where('operator_id', $operator->id)->first();
            switch ($task->operation) {
                case 'new_car':
                    $msg_id = MessageLayout::taskNtfyNewCar($operator, $task->taskable);
                    break;
                case 'new_operator':
                    $msg_id = MessageLayout::taskNtfyNewOperator($operator, $task->taskable);
                    break;
                case 'finished_auction':
                    $msg_id = MessageLayout::taskNtfyFnshdAuction($operator, $task->taskable);
                    break;
            }
            if ($msg)
                $msg->update([
                    'msg_id' => $msg_id,
                ]);
            else
                $task->messages()->create([
                    'msg_id' => $msg_id,
                    'operator_id' => $operator->id,
                ]);
        }
    }
}
