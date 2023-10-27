<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index')->with('setting', Setting::first());
    }

    public function edit(Setting $setting)
    {
        return view('setting.edit')->with('setting', $setting);
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'auction_expire_duration' => ['required', 'integer', 'min:5']
        ]);

        $setting->update([
            'auction_expire_duration' => $request->auction_expire_duration
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Settings successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('setting', $setting);
    }
}
