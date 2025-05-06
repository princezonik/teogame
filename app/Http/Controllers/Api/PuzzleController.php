<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;

class PuzzleController extends Controller
{
    public function today() {
        // return Puzzle::whereDate('date', today())->firstOrFail();

        $today = now()->toDateString(); // Get today's date
        $puzzle = Puzzle::where('date', $today)->first();

        if (!$puzzle) {
            return response()->json(['message' => 'Puzzle not found for today.'], 404);
        }

        return response()->json([
            'date' => $puzzle->date,
            'seed' => $puzzle->seed,
            'data' => $puzzle->data,
            'solution' => $puzzle->solution,
        ]);
    }

    
}
