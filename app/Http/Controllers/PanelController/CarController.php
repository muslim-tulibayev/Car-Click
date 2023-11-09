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
            "company" => ['required', 'string', 'max:255'],
            "model" => ['required', 'string', 'max:255'],
            "year" => ['required', 'integer', 'min:1900', 'max:' . now()->format('Y')],
            "color" => ['required', 'string', 'max:255'],
            "condition" => ['required', 'in:bad,good,new'],
            "status" => ['required', 'in:waiting_validation,on_sale,not_sold,didnt_sell,sold_out'],
            "additional" => ['nullable', 'string', 'max:255'],
            "user_id" => ['nullable', 'exists:users,id'],
            "dealer_id" => ['nullable', 'exists:dealers,id'],
        ]);

        $car->update([
            "company" => $request->company,
            "model" => $request->model,
            "year" => $request->year,
            "color" => $request->color,
            "condition" => $request->condition,
            "status" => $request->status,
            "additional" => $request->additional ?? null,
            "user_id" => $request->user_id,
            "dealer_id" => $request->dealer_id,
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
