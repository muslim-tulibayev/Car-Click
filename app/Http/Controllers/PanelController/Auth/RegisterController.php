<?php

namespace App\Http\Controllers\PanelController\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:admins,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $credentials['password'] = Hash::make($credentials['password']);
        $new_user = Admin::create($credentials);

        auth()->login($new_user);

        return redirect()->route('home');
    }
}
