<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CraftingDecision;

class CraftingDecisionController extends Controller
{
    public function showForm()
    {
        return view('craft-roi');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'material_cost' => 'required|numeric|min:0.01',
            'market_price' => 'required|numeric|min:0.01',
        ]);

        $materialCost = $validated['material_cost'];
        $marketPrice = $validated['market_price'];
        $roi = (($marketPrice - $materialCost) / $materialCost) * 100;
        $recommendation = $roi > 0 ? 'Craft is Worth It' : 'Buy Instead';

        $decision = CraftingDecision::create([
            'material_cost' => $materialCost,
            'market_price' => $marketPrice,
            'roi_percentage' => $roi,
            'recommendation' => $recommendation,
        ]);

        return view('craft-roi', ['result' => $decision]);
    }
}
