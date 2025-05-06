<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;
use App\Models\Attempt;
use Illuminate\Support\Facades\Auth;

class AttemptController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'moves' => 'required|array',
            'time_ms' => 'required|integer',
        ]);

        $puzzle = Puzzle::whereDate('date', today())->firstOrFail();

        // Check solution logic here...

        $attempt = Attempt::create([
            'user_id' => Auth::id(),
            'puzzle_id' => $puzzle->id,
            'moves' => $data['moves'],
            'time_ms' => $data['time_ms'],
        ]);

        return response()->json(['message' => 'Attempt saved', 'attempt' => $attempt]);
    }
}
