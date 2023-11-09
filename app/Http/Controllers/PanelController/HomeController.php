<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $auctions = Auction::whereHas('car', function ($query) {
            $query->where('status', 'sold_out');
        })->get();

        $car_amount = 0;

        foreach ($auctions as $auction)
            $car_amount += $auction->highestPrice();

        return view('home')
            ->with('car_amount', $car_amount);
    }
}
