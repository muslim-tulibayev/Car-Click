<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $operators = Operator::orderByDesc('id')->paginate();

        return view('operator.index')
            ->with('operators', $operators);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Operator $operator)
    {
        return view('operator.show')->with('operator', $operator);
    }

    public function edit(Operator $operator)
    {
        return view('operator.edit')
            ->with('operator', $operator);
    }

    public function update(Request $request, Operator $operator)
    {
        $request->validate([
            "firstname" => ['required', 'string', 'max:255'],
            "lastname" => ['required', 'string', 'max:255'],
            "contact" => ['required', 'string', 'max:255'],
            "is_validated" => ['required', 'boolean'],
        ]);
        
        // if (!$operator->is_validated and $request->is_validated)

        $operator->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "contact" => $request->contact,
            "is_validated" => $request->is_validated,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Operator with ' . $operator->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('operator', $operator);
    }

    public function destroy(Operator $operator)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Operator with ' . $operator->id . ' id successfully deleted',
        ];

        $operator->delete();

        $operators = Operator::orderByDesc('id')->paginate();

        return redirect()
            ->route('operators.index')
            ->with('alert_success', $alert_success)
            ->with('operators', $operators);
    }
}
