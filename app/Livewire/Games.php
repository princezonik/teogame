<?php

namespace App\Livewire;

use Livewire\Component;

class Games extends Component
{
    // Declare the public property that will hold the games data
    public $games;

    // You can use mount() to set the initial value for the property
    public function mount($games)
    {
        // Assign the passed data to the public property
        $this->games = $games;
    }

    public function render()
    {
        return view('livewire.games');
    }
}
