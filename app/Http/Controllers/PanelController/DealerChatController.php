<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\Search;
use App\Models\DealerChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealerChatController extends Controller
{
    public function index()
    {
        $dealerchats = DealerChat::orderByDesc('id')->paginate();

        return view('dealerchat.index')
            ->with('dealerchats', $dealerchats);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DealerChat $dealerchat)
    {
        return view('dealerchat.show')->with('dealerchat', $dealerchat);
    }

    public function edit(DealerChat $dealerchat)
    {
        return view('dealerchat.edit')
            ->with('dealerchat', $dealerchat);
    }

    public function update(Request $request, DealerChat $dealerchat)
    {
        $request->validate([
            "chat_id" => ['required', 'string', 'max:255'],
            "dealer_id" => ['nullable', 'integer', 'exists:dealers,id'],
            "action" => ['required', 'string', 'max:255'],
            "data" => ['required', 'string', 'max:500'],
            "lang" => ['required', 'in:en,uz,ru'],
        ]);

        $dealerchat->update([
            "chat_id" => $request->chat_id,
            "dealer_id" => $request->dealer_id,
            "action" => $request->action,
            "data" => $request->data,
            "lang" => $request->lang,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Dealer with ' . $dealerchat->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('dealerchat', $dealerchat);
    }


    public function destroy(DealerChat $dealerchat)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Dealer with ' . $dealerchat->id . ' id successfully deleted',
        ];

        $dealerchat->delete();

        $dealerchats = DealerChat::orderByDesc('id')->paginate();

        return redirect()
            ->route('dealerchats.index')
            ->with('alert_success', $alert_success)
            ->with('dealerchats', $dealerchats);
    }




    public function search($col, $val)
    {
        return Search::search(DealerChat::class, 'dealerchat', $col, $val);
    }
}
