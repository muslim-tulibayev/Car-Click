<?php

namespace App\Http\Controllers\BotController\User;

use App\Models\UserChat;
use Illuminate\Http\Request;

class Update
{
    public static function handle(Request $request)
    {
        $request = json_decode($request->getContent());

        if (isset($request->message)) {
            $update = (object) [
                "chat_id" => $request->message->chat->id,
                "message_id" => $request->message->message_id,
                "tg_chat" => UserChat::where('chat_id', '=', $request->message->chat->id)->first(),
            ];
            if (isset($request->message->text)) {
                $update->type = 'text';
                $update->data = $request->message->text;
            } elseif (isset($request->message->photo)) {
                $update->type = 'photo';
                $update->data = $request->message->photo;
            } elseif (isset($request->message->contact)) {
                $update->type = 'contact';
                $update->data = $request->message->contact->phone_number;
            } else {
                $update->type = 'unsupported';
                $update->data = null;
            }
            if ($update->tg_chat)
                $update->action = explode('>', $update->tg_chat->action);
            return $update;
        }

        if (isset($request->callback_query)) {
            $update = (object) [
                "type" => 'callback_query',
                "data" => $request->callback_query->data,
                "chat_id" => $request->callback_query->from->id,
                "message_id" => $request->callback_query->message->message_id,
                "tg_chat" => UserChat::where('chat_id', '=', $request->callback_query->from->id)->first(),
            ];

            if ($update->tg_chat)
                $update->action = explode('>', $update->tg_chat->action);

            return $update;
        }

        return (object) [
            "type" => 'unsupported',
            "data" => null,
            "chat_id" => null,
            "message_id" => null,
            "tg_chat" => null,
            "action" => null,
        ];
    }
}
