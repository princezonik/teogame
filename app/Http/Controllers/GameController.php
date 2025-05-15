<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Livewire\Games;

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

   
   
}
