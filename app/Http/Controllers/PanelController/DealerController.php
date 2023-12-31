<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\Search;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealerController extends Controller
{
    public function index()
    {
        $dealers = Dealer::orderByDesc('id')->paginate();

        return view('dealer.index')
            ->with('dealers', $dealers);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Dealer $dealer)
    {
        return view('dealer.show')->with('dealer', $dealer);
    }

    public function edit(Dealer $dealer)
    {
        return view('dealer.edit')
            ->with('dealer', $dealer);
    }

    public function update(Request $request, Dealer $dealer)
    {
        $request->validate([
            "firstname" => ['required', 'string', 'max:255'],
            "lastname" => ['required', 'string', 'max:255'],
            "contact" => ['required', 'string', 'max:255'],
        ]);

        $dealer->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "contact" => $request->contact,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Dealer with ' . $dealer->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('dealer', $dealer);
    }

    public function destroy(Dealer $dealer)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Dealer with ' . $dealer->id . ' id successfully deleted',
        ];

        $dealer->delete();

        $dealers = Dealer::orderByDesc('id')->paginate();

        return redirect()
            ->route('dealers.index')
            ->with('alert_success', $alert_success)
            ->with('dealers', $dealers);
    }





    public function search($col, $val)
    {
        return Search::search(Dealer::class, 'dealer', $col, $val);
    }
}
