<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwitchRevenueEstimation;

class TwitchRevenueEstimatorController extends Controller
{
    public function show()
    {
        return view('twitch_estimator');
    }

    public function estimate(Request $request)
    {
        $data = $request->validate([
            'tier1_subs' => 'required|integer|min:0',
            'bits' => 'required|integer|min:0',
            'ad_views' => 'required|integer|min:0',
        ]);

        // Twitch baseline revenue splits
        $subRevenue = $data['tier1_subs'] * 2.50;
        $bitRevenue = $data['bits'] * 0.01;
        $adRevenue = ($data['ad_views'] / 1000) * 3.50;

        $totalRevenue = round($subRevenue + $bitRevenue + $adRevenue, 2);

        // Optionally save
        TwitchRevenueEstimation::create([
            ...$data,
            'estimated_revenue' => $totalRevenue,
        ]);

        return view('twitch_estimator', [
            ...$data,
            'estimated_revenue' => $totalRevenue,
        ]);
    }
}
