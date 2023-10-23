<?php

namespace App\Http\Controllers\BotController\Dealer;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Traits\SendValidatorMessagesTrait;

class CarLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        switch ($update->action[2]) {
            case 'show_one_car':
                self::showOneCar($update);
                return true;
            default:
                return false;
        }
    }






    private static function showOneCar($update)
    {
        if ($update->data === trans('msg.cancel_btn')) {
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id - 1,
            ]);
            return Command::cancel($update);
        }
        if ($update->type !== 'callback_query')
            return HomeLayer::myCars($update);
        $update->tg_chat->update(['action' => 'home>end']);
        $car = $update->tg_chat->dealer->cars()
            ->find($update->data);
        if (!$car) return;
        $album = [];
        foreach ($car->images as $image)
            $album[] = [
                'type' => 'photo',
                'media' => $image->file_id,
            ];
        $album[0]['caption'] = trans('msg.car_info', [
            'id' => $car->id,
            'status' => trans('msg.' . $car->status),
            'company' => $car->company,
            'model' => $car->model,
            'year' => $car->year,
            'color' => $car->color,
            'condition' => trans('msg.' . $car->condition),
            'additional' => $car->additional,
            'owner_fname' => $car->user->firstname,
            'owner_lname' => $car->user->lastname,
            'winner_fname' => $car->dealer->firstname ?? null,
            'winner_lname' => $car->dealer->lastname ?? null,
        ]);
        $update->bot->sendMediaGroup([
            'chat_id' => $update->chat_id,
            'media' => json_encode($album),
        ]);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('dealer'),
            'text' => trans('msg.choose_section'),
        ]);
    }
}
