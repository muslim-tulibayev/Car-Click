<?php

namespace App\Http\Controllers\PanelController;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::orderByDesc('id')->paginate();

        return view('car.index')
            ->with('cars', $cars);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Car $car)
    {
        return view('car.show')->with('car', $car);
    }

    public function edit(Car $car)
    {
        return view('car.edit')
            ->with('car', $car);
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            "car_id" => ['required', 'integer', 'exists:cars,id'],
            "starting_price" => ['required', 'integer', 'min:0'],
            "highest_price" => ['required', 'integer', 'min:0'],
            "highest_price_owner_id" => ['required', 'integer', 'exists:dealers,id'],
            "life_cycle" => ['required', 'in:waiting_start,playing,waiting_confirmation,finished'],
            'start' => ['required', 'date_format:Y-m-d\TH:i'],
            'finish' => ['required', 'date_format:Y-m-d\TH:i', 'after:start'],
        ]);

        // $start = DateTime::createFromFormat('Y-m-d\TH:i', $request->start)

        //     // * input (datetime-local) tag sends time in T0 timezone
        //     ->setTimezone(new DateTimeZone('GMT-5'));

        // $finish = DateTime::createFromFormat('Y-m-d\TH:i', $request->finish)

        //     // * input (datetime-local) tag sends time in T0 timezone
        //     ->setTimezone(new DateTimeZone('GMT-5'));

        $car->update([
            "car_id" => $request->car_id,
            "starting_price" => $request->starting_price,
            "highest_price" => $request->highest_price,
            "highest_price_owner_id" => $request->highest_price_owner_id,
            "life_cycle" => $request->life_cycle,
            // 'start' => $start->format('Y-m-d H:i:s'),
            // 'finish' => $finish->format('Y-m-d H:i:s'),
        ]);

        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Car with ' . $car->id . ' id successfully updated',
        ];

        return back()
            ->with('alert_success', $alert_success)
            ->with('car', $car);
    }

    public function destroy(Car $car)
    {
        $alert_success = (object) [
            'primary' => 'Success',
            'text' => 'Car with ' . $car->id . ' id successfully deleted',
        ];

        $car->delete();

        $cars = Car::orderByDesc('id')->paginate();

        return redirect()
            ->route('cars.index')
            ->with('alert_success', $alert_success)
            ->with('cars', $cars);
    }
}
