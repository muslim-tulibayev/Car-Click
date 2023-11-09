<?php

namespace App\Http\Controllers\Auction;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Auction;
use App\Models\Setting;
use DateTime;
use DateTimeZone;
use Telegram\Bot\Laravel\Facades\Telegram;

class AuctionController
{
    public static function broadcast($data)
    {
        $start = new DateTime($data->start, new DateTimeZone('GMT+5'));
        $start->setTimezone(new DateTimeZone('GMT+0'));
        $start->setTime($start->format('H'), $start->format('i'), 0);
        $now = now()->second(0);
        if ($start < $now)
            $start = $now;
        $new_auction = Auction::create([
            "car_id" => $data->car_id,
            "starting_price" => $data->starting_price,
            "start" => $start->format('Y-m-d H:i:s'),
            "finish" => $start
                ->modify('+ ' . Setting::first()->auction_expire_duration . ' minutes')
                ->format('Y-m-d H:i:s'),
        ]);
        $new_auction->car->update(["status" => 'on_sale']);
        app()->setLocale('ru');
        $album = [];
        foreach ($new_auction->car->images as $image)
            $album[] = [
                'type' => 'photo',
                'media' => $image->file_id,
            ];
        $album[0]['caption'] = trans('msg.broadcast_message', [
            'company' => $new_auction->car->company,
            'model' => $new_auction->car->model,
            'year' => $new_auction->car->year,
            'color' => $new_auction->car->color,
            'condition' => trans('msg.' . $new_auction->car->condition),
            'additional' => $new_auction->car->additional,
            'start' => $new_auction->getStart(),
            'finish' => $new_auction->getFinish(),
            'starting_price' => $new_auction->starting_price,
        ]);
        Telegram::bot('dealer-bot')->sendMediaGroup([
            'chat_id' => env('BROADCASTING_CHANNEL_ID'),
            'media' => json_encode($album),
        ]);
        $response = Telegram::bot('dealer-bot')->sendMessage([
            'chat_id' => env('BROADCASTING_CHANNEL_ID'),
            'reply_markup' => KeyboardLayout::auctionJoin($new_auction->id),
            'text' => trans('msg.join_to_auction_msg'),
        ]);
        $new_auction->update(['join_btn_message_id' => $response->message_id]);
        return $new_auction;
    }









    public static function finish()
    {
        $auctions = Auction::where('life_cycle', 'playing')
            ->where('finish', '<=', now()->format('Y-m-d H:i:s'))
            ->get();

        foreach ($auctions as $auction) {

            Telegram::bot('dealer-bot')->deleteMessage([
                'chat_id' => env('BROADCASTING_CHANNEL_ID'),
                'message_id' => $auction->join_btn_message_id,
            ]);

            if (!$auction->highestPrice()) {
                self::deactivateAuctionWithNotSold($auction);
                continue;
            }
            self::askConfirmation($auction);
        }
    }








    public static function start()
    {
        $auctions = Auction::where('life_cycle', 'waiting_start')
            ->where('start', '<=', now()->format('Y-m-d H:i:s'))
            ->get();

        foreach ($auctions as $auction)
            self::startAuction($auction);
    }




    private static function startAuction($auction)
    {
        $auction->update(["life_cycle" => 'playing']);

        app()->setLocale($auction->car->user->tg_chat->lang);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'parse_mode' => 'html',
            'text' => trans('msg.auction_started_for_owner', [
                'car_id' => $auction->car->id,
                'color' => $auction->car->color,
                'company' => $auction->car->company,
                'model' => $auction->car->model,
                'starting_price' => $auction->starting_price,
            ]),
        ]);

        foreach ($auction->dealers as $dealer) {
            app()->setLocale($dealer->tg_chat->lang);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'parse_mode' => 'html',
                'text' => trans('msg.auction_started_for_dealer'),
            ]);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'text' => trans('msg.write_price'),
            ]);
        }
    }





    private static function askConfirmation($auction)
    {
        $auction->update(["life_cycle" => 'waiting_confirmation']);

        app()->setLocale($auction->car->user->tg_chat->lang);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'text' => trans('msg.auction_finished'),
        ]);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'reply_markup' => KeyboardLayout::ownerConfirm($auction->id),
            'text' => trans('msg.owner_confirm_message', [
                'color' => $auction->car->color,
                'company' => $auction->car->company,
                'model' => $auction->car->model,
                'highest_price' => $auction->highestPrice(),
            ]),
        ]);

        foreach ($auction->dealers as $dealer) {
            $dealer->tg_chat->update(["action" => 'home>end']);
            app()->setLocale($dealer->tg_chat->lang);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'text' => trans('msg.auction_finished'),
            ]);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'reply_markup' => KeyboardLayout::home('dealer'),
                'text' => trans('msg.pending_reply_from_the_owner'),
            ]);
        }
    }




    public static function deactivateAuctionWithAgreement($auction_id)
    {
        $auction = Auction::where('life_cycle', 'waiting_confirmation')
            ->find($auction_id);

        if (!$auction) return;

        $auction->update(['life_cycle' => 'finished']);

        $auction->car->update([
            "dealer_id" => $auction->highestPriceOwner()->id,
            "status" => 'sold_out',
        ]);

        app()->setLocale($auction->car->user->tg_chat->lang);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'parse_mode' => 'html',
            'text' => trans('msg.car_sold_message_for_owner', [
                'car_id' => $auction->car->id,
                'firstname' => $auction->car->user->firstname,
                'lastname' => $auction->car->user->lastname,
                'winner_fname' => $auction->highestPriceOwner()->firstname,
                'winner_lname' => $auction->highestPriceOwner()->lastname,
                'color' => $auction->car->color,
                'company' => $auction->car->company,
                'model' => $auction->car->model,
                'highest_price' => $auction->highestPrice(),
            ]),
        ]);

        foreach ($auction->dealers as $dealer) {
            app()->setLocale($dealer->tg_chat->lang);
            if ($dealer->id === $auction->highestPriceOwner()->id) {
                Telegram::bot('dealer-bot')->sendMessage([
                    'chat_id' => $dealer->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'text' => trans('msg.car_sold_message_for_winner', [
                        'car_id' => $auction->car->id,
                        'firstname' => $dealer->firstname,
                        'lastname' => $dealer->lastname,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                        'highest_price' => $auction->highestPrice(),
                    ]),
                ]);
                continue;
            }
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'parse_mode' => 'html',
                'text' => trans('msg.car_sold_message_for_dealers', [
                    'firstname' => $auction->highestPriceOwner()->firstname,
                    'lastname' => $auction->highestPriceOwner()->lastname,
                    'color' => $auction->car->color,
                    'company' => $auction->car->company,
                    'model' => $auction->car->model,
                    'highest_price' => $auction->highestPrice(),
                ]),
            ]);
        }

        return QueueController::make('finished_auction', $auction->id);
    }





    public static function deactivateAuctionWithDisagreement($auction_id)
    {
        $auction = Auction::where('life_cycle', 'waiting_confirmation')
            ->find($auction_id);

        if (!$auction) return;

        $auction->update(['life_cycle' => 'finished']);

        $auction->car->update(["status" => 'didnt_sell']);

        app()->setLocale($auction->car->user->tg_chat->lang);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'parse_mode' => 'html',
            'text' => trans('msg.didnt_sell_message_for_owner', [
                'firstname' => $auction->car->user->firstname,
                'lastname' => $auction->car->user->lastname,
                'color' => $auction->car->color,
                'company' => $auction->car->company,
                'model' => $auction->car->model,
                'car_id' => $auction->car->id,
                'highest_price' => $auction->highestPrice(),
            ]),
        ]);

        foreach ($auction->dealers as $dealer) {
            app()->setLocale($dealer->tg_chat->lang);
            if ($dealer->id === $auction->highestPriceOwner()->id) {
                Telegram::bot('dealer-bot')->sendMessage([
                    'chat_id' => $dealer->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'text' => trans('msg.didnt_sell_message_for_winner', [
                        'firstname' => $dealer->firstname,
                        'lastname' => $dealer->lastname,
                        'color' => $auction->car->color,
                        'company' => $auction->car->company,
                        'model' => $auction->car->model,
                        'highest_price' => $auction->highestPrice(),
                    ]),
                ]);
                continue;
            }
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'parse_mode' => 'html',
                'text' => trans('msg.didnt_sell_message_for_dealers', [
                    'color' => $auction->car->color,
                    'company' => $auction->car->company,
                    'model' => $auction->car->model,
                    'highest_price' => $auction->highestPrice(),
                ]),
            ]);
        }

        return QueueController::make('finished_auction', $auction->id);
    }





    public static function deactivateAuctionWithNotSold($auction)
    {
        $auction->update(["life_cycle" => 'finished']);
        $auction->car->update(["status" => 'not_sold']);

        app()->setLocale($auction->car->user->tg_chat->lang);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'parse_mode' => 'html',
            'text' => trans('msg.car_not_sold_message_for_owner', [
                'firstname' => $auction->car->user->firstname,
                'lastname' => $auction->car->user->lastname,
                'color' => $auction->car->color,
                'company' => $auction->car->company,
                'model' => $auction->car->model,
                'starting_price' => $auction->car->starting_price,
            ]),
        ]);

        foreach ($auction->dealers as $dealer) {
            $dealer->tg_chat->update(["action" => 'home>end']);

            app()->setLocale($dealer->tg_chat->lang);
            Telegram::bot('dealer-bot')->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'parse_mode' => 'html',
                'reply_markup' => KeyboardLayout::home('dealer'),
                'text' => trans('msg.car_not_sold_message_for_dealers', [
                    'starting_price' => $auction->starting_price,
                    'color' => $auction->car->color,
                    'company' => $auction->car->company,
                    'model' => $auction->car->model,
                ]),
            ]);
        }

        return QueueController::make('finished_auction', $auction->id);
    }
}
