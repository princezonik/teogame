<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TtkCalculation;

class TtkCalculatorController extends Controller
{
    public function showForm()
    {
        return view('dps_calculator');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'dps' => 'required|numeric|gt:0',
            'hp' => 'required|numeric|gt:0',
        ]);

        $dps = $request->input('dps');
        $hp = $request->input('hp');
        $ttk = $hp / $dps;

        // Optional: Save to database
        TtkCalculation::create([
            'dps' => $dps,
            'hp' => $hp,
            'ttk' => $ttk,
        ]);

        return view('dps_calculator', compact('dps', 'hp', 'ttk'));
    }
}
