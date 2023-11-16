<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::orderByDesc('id')->paginate();

        return view('setting.alerts')
            ->with('alerts', $alerts);
    }


    public function destroy(Alert $alert)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Alert with ' . $alert->id . ' id successfully deleted',
        ];

        $alert->delete();

        $alerts = Alert::orderByDesc('id')->paginate();

        return redirect()
            ->route('alerts.index')
            ->with('alert_success', $alert_success)
            ->with('alerts', $alerts);
    }


    public function destroyAll()
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'All alerts successfully deleted',
        ];

        Alert::truncate();

        $alerts = Alert::orderByDesc('id')->paginate();

        return redirect()
            ->route('alerts.index')
            ->with('alert_success', $alert_success)
            ->with('alerts', $alerts);
    }
}
