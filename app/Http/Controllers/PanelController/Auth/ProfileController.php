<?php

namespace App\Http\Controllers\PanelController\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.profile', [
            'firstname' => auth()->user()->firstname,
            'lastname' => auth()->user()->lastname,
            'username' => auth()->user()->username,
        ]);
    }

    public function update(Request $request)
    {
        $credentials = $request->validate([
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:admins,username,' . auth()->user()->id],
        ]);

        auth()->user()->update($credentials);

        return view('profile.profile', [
            'updated_message' => 'Your changes updated successfully',
            'firstname' => auth()->user()->firstname,
            'lastname' => auth()->user()->lastname,
            'username' => auth()->user()->username,
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
            return back()
                ->withInput()
                ->withErrors($validator->messages());

        if (!Hash::check($request->current_password, auth()->user()->password))
            return back()
                ->withInput()
                ->withErrors([
                    'current_password' => 'Password is wrong'
                ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return view('profile.profile', [
            'updated_message' => 'Your password updated successfully',
            'firstname' => auth()->user()->firstname,
            'lastname' => auth()->user()->lastname,
            'username' => auth()->user()->username,
        ]);
    }

    public function deleteAccountShowModal()
    {
        return view('profile.delete');
    }

    public function deleteAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails())
            return back()
                ->withInput()
                ->withErrors($validator->messages());

        if (!Hash::check($request->password, auth()->user()->password))
            return back()
                ->withInput()
                ->withErrors([
                    'password' => 'Password is wrong'
                ]);

        auth()->user()->delete();

        return redirect()->route('login');
    }
}
