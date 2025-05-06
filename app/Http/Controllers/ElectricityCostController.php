<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectricityCost;

class ElectricityCostController extends Controller
{
    public function showForm()
    {
        return view('electricity_cost');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'wattage' => 'required|integer|min:1',
            'rate_per_kwh' => 'required|numeric|min:0.01',
            'hours_per_day' => 'required|numeric|min:0|max:24',
        ]);

        $kwh_per_hour = $validated['wattage'] / 1000;
        $cost_per_hour = $kwh_per_hour * $validated['rate_per_kwh'];
        $cost_per_day = $cost_per_hour * $validated['hours_per_day'];
        $cost_per_month = $cost_per_day * 30;

        $entry = ElectricityCost::create([
            ...$validated,
            'cost_per_hour' => $cost_per_hour,
            'cost_per_day' => $cost_per_day,
            'cost_per_month' => $cost_per_month,
        ]);

        return view('electricity_cost', ['result' => $entry]);
    }
}
