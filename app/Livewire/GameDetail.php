<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;


class GameDetail extends Component
{

   public $game;

    // The mount method will load the game
    public function mount(Game $game)
    {
        $this->game = $game;
    }

    public function render()
    {
        return view('livewire.game-detail');
    }
    
}
