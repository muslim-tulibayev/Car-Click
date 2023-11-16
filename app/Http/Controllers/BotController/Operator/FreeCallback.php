<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Message\MessageLayout;
use App\Http\Controllers\Task\TaskManage;
use App\Models\Task;

class FreeCallback
{
    public static function handle($update)
    {
        if ($update->type !== 'callback_query')
            return false;

        $type = explode('|', $update->data)[0]; // * type

        switch ($type) {
            case 'task-ntfy':
                self::taskNtfy($update);
                return true;
            case 'task':
                self::task($update);
                return true;
            case 'dealer':
                self::getDealerInfo($update);
                return true;
            case 'bids-list':
                self::getBidsList($update);
                return true;
            default:
                return false;
        }
    }





    private static function getBidsList($update)
    {
        $type = explode('|', $update->data)[1]; // * type: [prev, next]
        $data = explode('|', $update->data)[2]; // * data: [current_page]

        switch ($type) {
            case 'prev':
                BidLayer::editList($update, $data - 1);
                break;
            case 'next':
                BidLayer::editList($update, $data + 1);
                break;
        }
    }





    private static function getDealerInfo($update)
    {
        $type = explode('|', $update->data)[1]; // * type [prev, cancel, next, info]
        $data = explode('|', $update->data)[2]; // * data: info -> dealer_id, prev|next|cancel -> current_page

        switch ($type) {
            case 'prev':
                DealerLayer::editList($update, $data - 1);
                break;
            case 'next':
                DealerLayer::editList($update, $data + 1);
                break;
            case 'info':
                DealerLayer::getInfo($update, $data);
                break;
            default:
                DealerLayer::removeList($update);
                break;
        }
    }





    private static function taskNtfy($update)
    {
        $id = explode('|', $update->data)[1]; // * task id
        $data = explode('|', $update->data)[2]; // * data [take, remove]

        $task = Task::where('operator_id', null)->where('is_done', false)->find($id);
        if (!$task)
            return MessageLayout::taskNotFound($update, trans('msg.task_not_found_msg'));

        switch ($data) {
            case 'take':
                if ($update->tg_chat->action !== 'home>end')
                    return MessageLayout::answerCallbackQuery($update, trans('msg.cant_take_task_msg'));
                return TaskManage::take($task, $update->tg_chat->operator);

            default:
                return TaskManage::remove($task, $update->tg_chat->operator);
        }
    }




    private static function task($update)
    {
        $id = explode('|', $update->data)[1]; // * task [id]
        $data = explode('|', $update->data)[2]; // * data [done, allow, deny]

        $task = Task::where('is_done', false)->find($id);
        if (!$task)
            return MessageLayout::taskNotFound($update, trans('msg.task_not_found_msg'));

        $operator = $update->tg_chat->operator;
        if ($task->operator_id !== $operator->id) return;

        // * Remove each callbacks here first
        MessageLayout::taskRmAnsweredMsg($task, $update);

        TaskManage::workOn($task, $data);
    }
}
