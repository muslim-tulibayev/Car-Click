<?php

namespace App\Http\Controllers\BotController\Dealer;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Auction;

class FreeCallback
{
    public static function handle($update)
    {
        if ($update->type !== 'callback_query')
            return false;

        // * Remove each callbacks here first
        // * Exception
        if ($update->real_chat_id != env('BROADCASTING_CHANNEL_ID'))
            $update->bot->deleteMessage([
                'chat_id' => $update->chat_id,
                'message_id' => $update->message_id,
            ]);

        $data = explode(':', $update->data);
        switch ($data[0]) {
            case 'auction_join':
                self::joinToAuction($update, $data);
                return true;
            default:
                return false;
        }
    }






    private static function joinToAuction($update, $data)
    {
        // * Gate
        if (!$update->tg_chat) return;
        if (!$update->tg_chat->dealer) return;
        if (!$update->tg_chat->dealer->is_validated) return;
        // * if dealer is already in any auction or click two times 'Join' button -> 'Abort'
        if ($update->tg_chat->action === 'auction>end') {
            if ($update->tg_chat->data === $data[1])
                return $update->bot->answerCallbackQuery([
                    'callback_query_id' => $update->callback_query_id,
                    'text' => trans('msg.already_joined_this_auction'),
                    'show_alert' => true,
                ]);
            return $update->bot->answerCallbackQuery([
                'callback_query_id' => $update->callback_query_id,
                'text' => trans('msg.already_joined_another_auction'),
                'show_alert' => true,
            ]);
        }
        $auction = Auction::find($data[1]);
        if (!$auction) return;
        if ($auction->life_cycle !== 'waiting_start' and $auction->life_cycle !== 'playing') return;
        $update->tg_chat->update([
            'action' => 'auction>end',
            'data' => $auction->id,
        ]);
        $update->tg_chat->dealer
            ->auctions()
            ->attach($auction->id);
        $album = [];
        foreach ($auction->car->images as $image)
            $album[] = [
                'type' => 'photo',
                'media' => $image->file_id,
            ];
        $album[0]['caption'] = trans('msg.broadcast_message', [
            'company' => $auction->car->company,
            'model' => $auction->car->model,
            'year' => $auction->car->year,
            'color' => $auction->car->color,
            'condition' => trans('msg.' . $auction->car->condition),
            'additional' => $auction->car->additional,
            'start' => $auction->getStart(),
            'finish' => $auction->getFinish(),
            'starting_price' => $auction->starting_price,
        ]);
        
        $update->bot->answerCallbackQuery([
            'callback_query_id' => $update->callback_query_id,
            'text' => trans('msg.joined_the_auction'),
            'show_alert' => true,
        ]);
        $update->bot->sendMediaGroup([
            'chat_id' => $update->chat_id,
            'media' => json_encode($album),
        ]);
        if ($auction->life_cycle === 'waiting_start')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::auctionLeft(),
                'text' => trans('msg.auction_hasnt_started_yet'),
            ]);
        if ($auction->life_cycle === 'playing') {
            $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.auction_info_msg_for_dealers', [
                    'highest_price' => $auction->highest_price,
                    'participants' => $auction->dealers()->count(),
                    'finish' => $auction->getFinish(),
                    'enough_price' => $auction->highest_price + 50,
                ]),
            ]);
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'reply_markup' => KeyboardLayout::auctionLeft(),
                'text' => trans('msg.write_price'),
            ]);
        }
    }
}
