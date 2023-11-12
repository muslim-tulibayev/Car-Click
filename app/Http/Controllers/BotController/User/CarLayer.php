<?php

namespace App\Http\Controllers\BotController\User;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Car;
use App\Models\Operator;
use Illuminate\Support\Facades\Validator;
use App\Traits\SendValidatorMessagesTrait;
use Telegram\Bot\Laravel\Facades\Telegram;

class CarLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        switch ($update->action[2]) {
            case 'adding':
                self::adding($update);
                return true;
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
        $car = $update->tg_chat->user->cars()->find($update->data);
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
            'reply_markup' => KeyboardLayout::home('user'),
            'text' => trans('msg.choose_section'),
        ]);
    }







    private static function adding($update)
    {
        switch ($update->action[3]) {
            case 'waiting_company':
                return self::waitingCompany($update);
            case 'waiting_model':
                return self::waitingModel($update);
            case 'waiting_year':
                return self::waitingYear($update);
            case 'waiting_color':
                return self::waitingColor($update);
            case 'waiting_condition':
                return self::waitingCondition($update);
            case 'waiting_images':
                return self::waitingImages($update);
            case 'waiting_additional':
                return self::waitingAdditional($update);
            default:
                return;
        }
    }







    private static function waitingCompany($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        $validator = Validator::make(
            ["company" => $update->data],
            ["company" => 'string']
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $update->tg_chat->update([
            'action' => 'home>car>adding>waiting_model',
            'data' => json_encode(['company' => $update->data]),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_car_model'),
        ]);
    }
    private static function waitingModel($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        $validator = Validator::make(
            ["model" => $update->data],
            ["model" => 'string']
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $data = json_decode($update->tg_chat->data);
        $data->model = $update->data;
        $update->tg_chat->update([
            'action' => 'home>car>adding>waiting_year',
            'data' => json_encode($data),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_car_year'),
        ]);
    }
    private static function waitingYear($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        $validator = Validator::make(
            ["year" => $update->data],
            ["year" => 'integer|min:1900|max:' . now()->format('Y')]
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $data = json_decode($update->tg_chat->data);
        $data->year = $update->data;
        $update->tg_chat->update([
            'action' => 'home>car>adding>waiting_color',
            'data' => json_encode($data),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_car_color'),
        ]);
    }
    private static function waitingColor($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        $validator = Validator::make(
            ["color" => $update->data],
            ["color" => 'string']
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $data = json_decode($update->tg_chat->data);
        $data->color = $update->data;
        $update->tg_chat->update([
            'action' => 'home>car>adding>waiting_condition',
            'data' => json_encode($data),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::chooseCarCondition(),
            'text' => trans('msg.ask_car_condition'),
        ]);
    }
    private static function waitingCondition($update)
    {
        if ($update->data === trans('msg.cancel_btn')) {
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id - 1,
            ]);
            return Command::cancel($update);
        }
        if ($update->type !== 'callback_query')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::chooseCarCondition(),
                'text' => trans('msg.ask_car_condition'),
            ]);
        $validator = Validator::make(
            ["color" => $update->data],
            ["color" => 'string']
        );
        if ($validator->fails()) return;
        $data = json_decode($update->tg_chat->data);
        $data->condition = $update->data;
        $update->tg_chat->update([
            'action' => 'home>car>adding>waiting_images',
            'data' => json_encode($data),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::cancel(),
            'text' => trans('msg.ask_car_image'),
        ]);
    }
    private static function waitingImages($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        if ($update->data === trans('msg.next_btn')) {
            $update->tg_chat->update([
                'action' => 'home>car>adding>waiting_additional',
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::next(),
                'text' => trans('msg.ask_car_additional', ['next' => trans('msg.next_btn')]),
            ]);
        }
        if ($update->type !== 'photo')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.invalid_image'),
            ]);
        $data = json_decode($update->tg_chat->data);
        if (isset($data->image_ids))
            $data->image_ids[] = $update->data[count($update->data) - 1]->file_id;
        else
            $data->image_ids = [
                $update->data[count($update->data) - 1]->file_id,
            ];
        if (count($data->image_ids) === 4) {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.image_limit_msg'),
            ]);
            $update->tg_chat->update([
                'action' => 'home>car>adding>waiting_additional',
                'data' => json_encode($data),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::next(),
                'text' => trans('msg.ask_car_additional', ['next' => trans('msg.next_btn')]),
            ]);
        }
        $update->tg_chat->update([
            'data' => json_encode($data),
        ]);
        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::next(),
            'text' => trans('msg.more_images', [
                'next_btn' => trans('msg.next_btn')
            ]),
        ]);
    }
    private static function waitingAdditional($update)
    {
        if ($update->data === trans('msg.cancel_btn'))
            return Command::cancel($update);
        $data = json_decode($update->tg_chat->data);
        if ($update->data === trans('msg.next_btn')) {
            $data->additional = null;
            return self::createCarAsNotValidated($update, $data);
        }
        $validator = Validator::make(
            ["additional_information" => $update->data],
            ["additional_information" => 'string|max:255']
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);
        $data->additional = $update->data;
        return self::createCarAsNotValidated($update, $data);
    }






    private static function createCarAsNotValidated($update, $data)
    {
        $update->tg_chat->update(["action" => 'home>end']);
        $new_car = $update->tg_chat->user->cars()->create([
            "company" => $data->company,
            "model" => $data->model,
            "year" => $data->year,
            "color" => $data->color,
            "condition" => $data->condition,
            "additional" => $data->additional,
        ]);

        // * Make images of the car as public among bots
        foreach ($data->image_ids as $image_id) {
            $update->bot->sendPhoto([
                'chat_id' => env('STORAGE_CHANNEL_ID'),
                'photo' => $image_id,
            ]);
            $response = json_decode(\Illuminate\Support\Facades\Http::get("https://api.telegram.org/bot" . env("TELEGRAM_BOT_TOKEN") ."/getFile?file_id=$image_id")->body());
            $new_car->images()->create([
                'file_id' => $image_id,
                'file_path' => $response->result->file_path,
            ]);
        }
        $album = [];
        foreach ($new_car->images as $image)
            $album[] = [
                'type' => 'photo',
                'media' => $image->file_id,
            ];
        $album[0]['caption'] = trans('msg.car_added_info', [
            'id' => $new_car->id,
            'company' => $new_car->company,
            'model' => $new_car->model,
            'year' => $new_car->year,
            'color' => $new_car->color,
            'condition' => trans('msg.' . $new_car->condition),
            'additional' => $new_car->additional,
        ]);
        $update->bot->sendMediaGroup([
            'chat_id' => $update->chat_id,
            'media' => json_encode($album),
        ]);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'text' => trans('msg.request_registered_msg'),
        ]);
        $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('user'),
            'text' => trans('msg.please_wait'),
        ]);

        return QueueController::make('new_car', $new_car->id);
    }
}
