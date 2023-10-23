<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auction\AuctionController;
use Illuminate\Console\Command;

class AuctionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction-check:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checks all auctions starting and finishing times and then start it or finish it';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        AuctionController::finish();
        AuctionController::start();

        return Command::SUCCESS;
    }
}
