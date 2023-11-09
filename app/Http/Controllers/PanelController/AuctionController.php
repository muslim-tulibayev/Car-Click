<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Auction\AuctionController as BroadcastController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Queue\QueueController;
use App\Models\Auction;
use App\Models\Car;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::orderByDesc('id')->paginate();

        return view('auction.index')
            ->with('auctions', $auctions);
    }

    public function create(Request $request)
    {
        if ($request->has('car_id')) {
            $car = Car::find($request->car_id);

            if (!$car)
                abort(404);
        }

        return view('auction.create')
            ->with('car_id', $request->car_id);
    }

    public function store(Request $request)
    {
        $request->validate([
            "car_id" => ['required', 'integer', 'exists:cars,id'],
            "starting_price" => ['required', 'integer', 'min:0'],
            'start' => ['required', 'date_format:Y-m-d\TH:i'],
        ]);

        $start = DateTime::createFromFormat('Y-m-d\TH:i', $request->start)

            // * input (datetime-local) tag sends time in T0 timezone
            ->setTimezone(new DateTimeZone('GMT-5'));

        $car = Car::find($request->car_id);

        $new_auction = BroadcastController::broadcast((object) [
            "car_id" => $car->id,
            "starting_price" => $request->starting_price,
            'start' => $start->format('Y-m-d H:i:s'),
        ]);

        if ($car->queueable)
            QueueController::finish($car->queueable, 'allow');

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Auction with ' . $new_auction->id . ' id successfully updated',
        ];

        return redirect()->route('auctions.show', ['auction' => $new_auction->id])
            ->with('alert_success', $alert_success)
            ->with('auction', $new_auction);
    }

    public function show(Auction $auction)
    {
        return view('auction.show')->with('auction', $auction);
    }

    public function edit(Auction $auction)
    {
        return view('auction.edit')
            ->with('auction', $auction);
    }

    public function update(Request $request, Auction $auction)
    {
        $request->validate([
            "car_id" => ['required', 'integer', 'exists:cars,id'],
            "starting_price" => ['required', 'integer', 'min:0'],
            // "highest_price" => ['required', 'integer', 'min:0'],
            // "highest_price_owner_id" => ['required', 'integer', 'exists:dealers,id'],
            "life_cycle" => ['required', 'in:waiting_start,playing,waiting_confirmation,finished'],
            'start' => ['required', 'date_format:Y-m-d\TH:i'],
            'finish' => ['required', 'date_format:Y-m-d\TH:i', 'after:start'],
        ]);

        $start = DateTime::createFromFormat('Y-m-d\TH:i', $request->start)

            // * input (datetime-local) tag sends time in T0 timezone
            ->setTimezone(new DateTimeZone('GMT-5'));

        $finish = DateTime::createFromFormat('Y-m-d\TH:i', $request->finish)

            // * input (datetime-local) tag sends time in T0 timezone
            ->setTimezone(new DateTimeZone('GMT-5'));

        $auction->update([
            "car_id" => $request->car_id,
            "starting_price" => $request->starting_price,
            // "highest_price" => $request->highest_price,
            // "highest_price_owner_id" => $request->highest_price_owner_id,
            "life_cycle" => $request->life_cycle,
            'start' => $start->format('Y-m-d H:i:s'),
            'finish' => $finish->format('Y-m-d H:i:s'),
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Auction with ' . $auction->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('auction', $auction);
    }

    public function destroy(Auction $auction)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Auction with ' . $auction->id . ' id successfully deleted',
        ];

        $auction->delete();

        $auctions = Auction::orderByDesc('id')->paginate();

        return redirect()
            ->route('auctions.index')
            ->with('alert_success', $alert_success)
            ->with('auctions', $auctions);
    }
}
