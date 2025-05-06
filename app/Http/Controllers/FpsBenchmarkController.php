<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FpsBenchmark;

class FpsBenchmarkController extends Controller
{
    // Return filtered FPS estimate
    public function estimate(Request $request)
    {
        $request->validate([
            'game_title' => 'required|string',
            'cpu_model' => 'required|string',
            'gpu_model' => 'required|string',
        ]);

        $query = FpsBenchmark::where('game_title', $request->game_title)
            ->where('cpu_model', $request->cpu_model)
            ->where('gpu_model', $request->gpu_model);

        $result = $query->first();

        if ($result) {
            return response()->json([
                'estimated_fps' => $result->average_fps,
                'resolution' => $result->resolution,
            ]);
        } else {
            return response()->json([
                'message' => 'No benchmark found for the selected configuration.'
            ], 404);
        }
    }
}
