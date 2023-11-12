<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index()
    {
        $bids = Bid::orderByDesc('id')->paginate();

        return view('bid.index')
            ->with('bids', $bids);
    }

    public function create(Request $request)
    {
        // 
    }

    public function store(Request $request)
    {
        // 
    }

    public function show(Bid $bid)
    {
        return view('bid.show')->with('bid', $bid);
    }

    public function edit(Bid $bid)
    {
        return view('bid.edit')
            ->with('bid', $bid);
    }

    public function update(Request $request, Bid $bid)
    {
        $request->validate([
            "auction_id" => ['required', 'integer', 'exists:auctions,id'],
            "dealer_id" => ['required', 'integer', 'exists:dealers,id'],
            "price" => ['required', 'integer', 'min:0'],
        ]);

        $bid->update([
            "auction_id" => $request->auction_id,
            "dealer_id" => $request->dealer_id,
            "price" => $request->price,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Bid with ' . $bid->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('bid', $bid);
    }

    public function destroy(Bid $bid)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Bid with ' . $bid->id . ' id successfully deleted',
        ];

        $bid->delete();

        $bids = Bid::orderByDesc('id')->paginate();

        return redirect()
            ->route('auctions.bids', ['auction' => $bid->auction->id])
            ->with('alert_success', $alert_success)
            ->with('bids', $bids);
    }
}
