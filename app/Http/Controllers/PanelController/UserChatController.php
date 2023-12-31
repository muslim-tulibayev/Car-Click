<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\Search;
use App\Models\UserChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserChatController extends Controller
{
    public function index()
    {
        $userchats = UserChat::orderByDesc('id')->paginate();

        return view('userchat.index')
            ->with('userchats', $userchats);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(UserChat $userchat)
    {
        return view('userchat.show')->with('userchat', $userchat);
    }

    public function edit(UserChat $userchat)
    {
        return view('userchat.edit')
            ->with('userchat', $userchat);
    }

    public function update(Request $request, UserChat $userchat)
    {
        $request->validate([
            "chat_id" => ['required', 'string', 'max:255'],
            "user_id" => ['nullable', 'integer', 'exists:users,id'],
            "action" => ['required', 'string', 'max:255'],
            "data" => ['required', 'string', 'max:500'],
            "lang" => ['required', 'in:en,uz,ru'],
        ]);

        $userchat->update([
            "chat_id" => $request->chat_id,
            "user_id" => $request->user_id,
            "action" => $request->action,
            "data" => $request->data,
            "lang" => $request->lang,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'User with ' . $userchat->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('userchat', $userchat);
    }


    public function destroy(UserChat $userchat)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'User with ' . $userchat->id . ' id successfully deleted',
        ];

        $userchat->delete();

        $userchats = UserChat::orderByDesc('id')->paginate();

        return redirect()
            ->route('userchats.index')
            ->with('alert_success', $alert_success)
            ->with('userchats', $userchats);
    }




    public function search($col, $val)
    {
        return Search::search(UserChat::class, 'userchat', $col, $val);
    }
}
