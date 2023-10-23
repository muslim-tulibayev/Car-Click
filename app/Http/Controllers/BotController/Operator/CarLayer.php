<?php

namespace App\Http\Controllers\BotController\Operator;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;
use App\Traits\SendValidatorMessagesTrait;

class CarLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        switch ($update->action[2]) {
            case 'get_info':
                self::getInfo($update);
                return true;
            default:
                return false;
        }
    }






    private static function getInfo($update)
    {
        if ($update->action[3] !== 'waiting_car_id')
            return;

        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);

        $validator = Validator::make(
            ["car_id" => $update->data],
            ["car_id" => 'integer|exists:cars,id']
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $update->tg_chat->update(['action' => 'home>end']);
        $car = Car::find($update->data);


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
            'owner_fname' => $car->user->firstname ?? null,
            'owner_lname' => $car->user->lastname ?? null,
            'winner_fname' => $car->dealer->firstname ?? null,
            'winner_lname' => $car->dealer->lastname ?? null,
        ]);

        $update->bot->sendMediaGroup([
            'chat_id' => $update->chat_id,
            'media' => json_encode($album),
        ]);

        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('operator'),
            'text' => trans('msg.choose_section'),
        ]);
    }
}
