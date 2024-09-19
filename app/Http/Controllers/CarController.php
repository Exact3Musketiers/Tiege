<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = new Car();
        if (! is_null(auth()->user())) {
            $cars = Car::where('user_id', auth()->user()->id)->get();
        }

        return view('cars.index', ['cars' => $cars]);
    }

    public function create()
    {
        $car = new Car();
        return view('cars.model', ['car' => $car]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'date_format:Y'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif', 'max:2048'],
            'total_distance' => ['nullable', 'integer'],
        ]);

        unset($validated['image']);

        if ($request->file('image') !== null)
        {
            $path = $request->file('image')->store(
                'images',
                'public'
            );

            $validated['image_path'] = $path;
        }

        $validated['user_id'] = auth()->user()->id;

        Car::create($validated);

        return redirect(route('driving.index'));
    }

    public function edit(Car $car)
    {
        return view('cars.model', ['car' => $car]);
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'date_format:Y'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif', 'max:2048'],
            'total_distance' => ['nullable', 'integer'],
        ]);

        unset($validated['image']);

        if ($request->file('image') !== null)
        {
            $path = $request->file('image')->store(
                'images',
                'public'
            );

            $validated['image_path'] = $path;
        }

        $car->update($validated);

        return redirect()->route('driving.index');
    }

    public function delete()
    {
        return view('cars.index');
    }
}
