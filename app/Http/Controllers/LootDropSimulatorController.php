<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LootDropSimulation;

class LootDropSimulatorController extends Controller
{
    public function showForm()
    {
        // Show the form for simulation
        return view('lootdrop_simulator');
    }

    public function calculate(Request $request)
    {
        // Validate the input
        $request->validate([
            'probability' => 'required|numeric|between:0,100', // percentage between 0 and 100
            'pulls' => 'required|integer|min:1', // number of pulls
        ]);

        // Convert probability to decimal (e.g., 50% -> 0.50)
        $probability = $request->input('probability') / 100;
        $pulls = $request->input('pulls');

        // Calculate the chance of getting at least one rare item
        $noLootProb = pow(1 - $probability, $pulls);
        $lootDropChance = 1 - $noLootProb;

        // Save the simulation result in the database
        LootDropSimulation::create([
            'probability' => $probability,
            'pulls' => $pulls,
            'loot_drop_chance' => $lootDropChance,
        ]);

        // Return the result back to the view
        return view('lootdrop_simulator', compact('lootDropChance', 'probability', 'pulls'));
    }
}
