<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Livewire\Games;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all(); 

        return view('games.index', compact('games'));
    }

    public function show($id)
    {
        $game = Game::findOrFail($id); // single game detail

        return view('games.show', ['game' => $game]);
    }


    public function store2048Score(Request $request)
    {
        $request->validate([
            'score' => 'required|integer|min:0',
            'game_id' => 'required|integer',
        ]);

        Score::create([
            'user_id' => Auth::id() ?? null, // Or handle guest if needed
            'game_id' => $request->game_id,
            'score' => $request->score,
        ]);

        broadcast(new \App\Events\ScoreUpdated($request->game_id));

        return response()->json(['message' => 'Score saved']);
    }
   
   
}
