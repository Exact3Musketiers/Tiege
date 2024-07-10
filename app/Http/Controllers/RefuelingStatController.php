<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RefuelingStat;
use Illuminate\Http\Request;

class RefuelingStatController extends Controller
{
    public function index(Car $car)
    {
        if ($car->user_id !== auth()->user()->getKey()) {
            abort('404');
        }

        $stats = RefuelingStat::where('car_id', $car->getKey())->orderBy('created_at', 'DESC')->get();

        return view('efficiency.index', ['car' => $car, 'stats' => $stats]);
    }

    public function create(Car $car)
    {
        if ($car->user_id !== auth()->user()->getKey()) {
            abort('404');
        }

        $stat = new RefuelingStat();

        return view('efficiency.model', ['car' => $car, 'stat' => $stat]);
    }

    public function store(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->user()->getKey()) {
            abort('404');
        }

        $validated = $request->validate([
            'odo_reading' => ['required', 'integer'],
            'liters_tanked' => ['required', 'numeric'],
            'price_per_liter' => ['required', 'numeric'],
            'record_date' => ['required', 'date'],
        ]);

        $validated['odo_reading'] = $validated['odo_reading'] - $car->total_distance;

        $usage = round($validated['odo_reading'] / $validated['liters_tanked'], 1);
        $validated['usage'] = RefuelingStat::convertToInt($usage);

        $validated['liters_tanked'] = RefuelingStat::convertToInt($validated['liters_tanked']);
        $validated['price_per_liter'] = RefuelingStat::convertToInt($validated['price_per_liter']);

        $validated['car_id'] = $car->getKey();

        RefuelingStat::create($validated);

        $history = RefuelingStat::where('car_id', $car->getKey())->pluck('usage')->toArray();

        $average = array_sum($history) / count($history);

        $car->update(['total_distance' => $car->total_distance + $validated['odo_reading'], 'avg_usage' => $average]);

        return redirect()->route('efficiency.index', ['car' => $car]);
    }
}
