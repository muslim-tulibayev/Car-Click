<?php

namespace App\Http\Controllers\PanelController\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (auth()->attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()
            ->withInput()
            ->withErrors([
                'wrong_credentials' => 'The provided credentials do not match our records.'
            ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
