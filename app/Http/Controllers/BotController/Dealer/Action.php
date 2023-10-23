<?php

namespace App\Http\Controllers\BotController\Dealer;

class Action
{
    public static function handle($update)
    {
        switch ($update->action[0]) {
            case 'start':
                StartLayer::handle($update);
                return true;
            case 'home':
                HomeLayer::handle($update);
                return true;
            case 'auction':
                AuctionLayer::handle($update);
                return true;
            default:
                return false;
        }
    }
}
