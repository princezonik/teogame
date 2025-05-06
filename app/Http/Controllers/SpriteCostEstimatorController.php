<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpriteCostEstimatorController extends Controller
{
    public function show()
    {
        return view('sprite_estimator');
    }

    public function estimate(Request $request)
    {
        $validated = $request->validate([
            'frames' => 'required|integer|min:1',
            'rate' => 'required|numeric|min:0',
        ]);

        $total = $validated['frames'] * $validated['rate'];

        return view('sprite_estimator', [
            'frames' => $validated['frames'],
            'rate' => $validated['rate'],
            'total' => $total,
        ]);
    }
}
