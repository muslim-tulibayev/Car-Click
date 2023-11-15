<?php

namespace App\Http\Controllers\BotController\User;

use App\Http\Controllers\Auction\AuctionManage;

class FreeCallback
{
    public static function handle($update)
    {
        if ($update->type !== 'callback_query')
            return false;

        // * Remove each callbacks here first
        $update->bot->deleteMessage([
            'chat_id' => $update->chat_id,
            'message_id' => $update->message_id,
        ]);

        $data = explode(':', $update->data);
        switch ($data[0]) {
            case 'owner_confirm|yes|auction_id':
                self::ownerConfirm($update, $data);
                return true;
            case 'owner_confirm|no|auction_id':
                self::ownerConfirm($update, $data);
                return true;
            default:
                return false;
        }
    }


    private static function ownerConfirm($update, $data)
    {
        if ($data[0] === 'owner_confirm|yes|auction_id')
            return AuctionManage::deactivateAuctionWithAgreement($data[1]);
        else
            return AuctionManage::deactivateAuctionWithDisagreement($data[1]);
    }
}
