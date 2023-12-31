<?php

namespace App\Http\Controllers\BotController\Dealer;

use App\Http\Controllers\BotController\Keyboard\KeyboardLayout;
use App\Models\Auction;
use App\Traits\SendValidatorMessagesTrait;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Laravel\Facades\Telegram;

class AuctionLayer
{
    use SendValidatorMessagesTrait;

    public static function handle($update)
    {
        // * Gate
        if (!$update->tg_chat->dealer) return;

        if ($update->action[1] !== 'end')
            return false;

        switch ($update->data) {
            case trans('msg.left_btn'):
                self::leftTheAuction($update);
                return true;
            default:
                self::setPrice($update);
                return true;
        }
    }






    private static function setPrice($update)
    {
        $auction = Auction::find($update->tg_chat->data);

        if ($auction->life_cycle === 'waiting_start')
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.auction_inactive'),
            ]);
        elseif ($auction->life_cycle !== 'playing')
            return;

        $update->data = str_replace('$', '', $update->data);
        $update->data = str_replace(' ', '', $update->data);
        $update->data = str_replace(',', '', $update->data);
        $validator = Validator::make(
            ["price" => $update->data],
            ["price" => 'integer|min:1'],
        );
        if ($validator->fails())
            return self::sendValidatorMessages($validator, $update);

        // * Highest price is equal to 0
        if (!$auction->highestPrice()) {
            if ($update->data < $auction->starting_price)
                return $update->bot->sendMessage([
                    'chat_id' => $update->chat_id,
                    'text' => trans('msg.price_lt_starting_price', [
                        'starting_price' => $auction->starting_price,
                    ]),
                ]);

            goto end;
        }

        // * Highest price is not null
        if ($update->data - $auction->highestPrice() < 50)
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.price_not_higher_enough', [
                    'enough_price' => $auction->highestPrice() + 50,
                ]),
            ]);
        else
            goto end;

        end:
        $auction->bids()->create([
            "dealer_id" => $update->tg_chat->dealer->id,
            "price" => $update->data,
        ]);
        Telegram::bot('user-bot')->sendMessage([
            'chat_id' => $auction->car->user->tg_chat->chat_id,
            'text' => trans('msg.auction_info_msg_for_owner', [
                // 'fname' => $auction->highestPriceOwner()->firstname,
                // 'lname' => $auction->highestPriceOwner()->lastname,
                // 'phone' => $auction->highestPriceOwner()->contact,
                'highest_price' => $auction->highestPrice(),
                'participants' => $auction->dealers()->count(),
                'finish' => $auction->getFinish(),
            ], $auction->car->user->tg_chat->lang),
        ]);
        foreach ($auction->dealers as $dealer) {
            if ($auction->highestPriceOwner()->id === $dealer->id) {
                $update->bot->sendMessage([
                    'chat_id' => $dealer->tg_chat->chat_id,
                    'parse_mode' => 'html',
                    'text' => trans('msg.auction_info_msg_for_current_winner', [
                        'highest_price' => $auction->highestPrice(),
                        'participants' => $auction->dealers()->count(),
                        'finish' => $auction->getFinish(),
                        'fname' => $dealer->firstname,
                        'lname' => $dealer->lastname
                    ], $dealer->tg_chat->lang),
                ]);
                continue;
            }
            $update->bot->sendMessage([
                'chat_id' => $dealer->tg_chat->chat_id,
                'text' => trans('msg.auction_info_msg_for_dealers', [
                    'highest_price' => $auction->highestPrice(),
                    'participants' => $auction->dealers()->count(),
                    'finish' => $auction->getFinish(),
                    'enough_price' => $auction->highestPrice() + 50
                ], $dealer->tg_chat->lang),
            ]);
        }
        return;
    }








    private static function leftTheAuction($update)
    {
        $dealer = $update->tg_chat->dealer;

        $auction = Auction::where('life_cycle', 'waiting_start')
            ->orWhere('life_cycle', 'playing')
            ->find($update->tg_chat->data);

        if (!$auction) return;

        if ($auction->highestPriceOwner() and ($auction->highestPriceOwner()->id === $dealer->id))
            return $update->bot->sendMessage([
                'chat_id' => $update->chat_id,
                'text' => trans('msg.cant_left'),
            ]);

        $auction->dealers()->detach($dealer->id);

        $update->tg_chat->update(["action" => 'home>end']);

        return $update->bot->sendMessage([
            'chat_id' => $update->chat_id,
            'reply_markup' => KeyboardLayout::home('dealer'),
            'text' => trans('msg.left'),
        ]);
    }
}
