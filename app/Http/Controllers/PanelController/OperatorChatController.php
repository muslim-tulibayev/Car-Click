<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\Search;
use App\Models\OperatorChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperatorChatController extends Controller
{
    public function index()
    {
        $operatorchats = OperatorChat::orderByDesc('id')->paginate();

        return view('operatorchat.index')
            ->with('operatorchats', $operatorchats);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(OperatorChat $operatorchat)
    {
        return view('operatorchat.show')->with('operatorchat', $operatorchat);
    }

    public function edit(OperatorChat $operatorchat)
    {
        return view('operatorchat.edit')
            ->with('operatorchat', $operatorchat);
    }

    public function update(Request $request, OperatorChat $operatorchat)
    {
        $request->validate([
            "chat_id" => ['required', 'string', 'max:255'],
            "operator_id" => ['nullable', 'integer', 'exists:operators,id'],
            "action" => ['required', 'string', 'max:255'],
            "data" => ['required', 'string', 'max:255'],
            "lang" => ['required', 'in:en,uz,ru'],
        ]);

        $operatorchat->update([
            "chat_id" => $request->chat_id,
            "operator_id" => $request->operator_id,
            "action" => $request->action,
            "data" => $request->data,
            "lang" => $request->lang,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Operator with ' . $operatorchat->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('operatorchat', $operatorchat);
    }


    public function destroy(OperatorChat $operatorchat)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Operator with ' . $operatorchat->id . ' id successfully deleted',
        ];

        $operatorchat->delete();

        $operatorchats = OperatorChat::orderByDesc('id')->paginate();

        return redirect()
            ->route('operatorchats.index')
            ->with('alert_success', $alert_success)
            ->with('operatorchats', $operatorchats);
    }




    public function search($col, $val)
    {
        return Search::search(OperatorChat::class, 'operatorchat', $col, $val);
    }
}
