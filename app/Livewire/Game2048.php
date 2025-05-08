<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Game2048 extends Component
{

    public $bestScore = 0;

   

    public function render()
    {
        return view('livewire.game2048');
    }
}
