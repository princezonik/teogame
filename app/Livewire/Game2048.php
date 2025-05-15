<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Game2048 extends Component
{

    public $bestScore = 0;

    public $game;

    // The mount method will load the game
    public function mount(Game $game)
    {
        $this->game = $game;
    }
   

    public function render()
    {
        return view('livewire.game2048');
    }
}
