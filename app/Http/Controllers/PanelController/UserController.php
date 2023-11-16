<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\Search;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate();

        return view('user.index')
            ->with('users', $users);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return view('user.show')->with('user', $user);
    }

    public function edit(User $user)
    {
        return view('user.edit')
            ->with('user', $user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            "firstname" => ['required', 'string', 'max:255'],
            "lastname" => ['required', 'string', 'max:255'],
            "contact" => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "contact" => $request->contact,
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'User with ' . $user->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('user', $user);
    }

    public function destroy(User $user)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'User with ' . $user->id . ' id successfully deleted',
        ];

        $user->delete();

        $users = User::orderByDesc('id')->paginate();

        return redirect()
            ->route('users.index')
            ->with('alert_success', $alert_success)
            ->with('users', $users);
    }




    public function search($col, $val)
    {
        return Search::search(User::class, 'user', $col, $val);
    }
}
