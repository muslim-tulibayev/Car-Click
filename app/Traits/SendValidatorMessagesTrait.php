<?php

namespace App\Traits;

trait SendValidatorMessagesTrait
{
    private static function sendValidatorMessages($validator, $update)
    {
        foreach ($validator->messages()->toArray() as $key => $value)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => $value[0],
            ]);
    }
}
