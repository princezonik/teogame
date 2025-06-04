<?php

namespace App\Livewire;


use Livewire\Component;
use App\Services\DailyGameService;
use App\Models\Game;

class Aside extends Component
{
    public ?Game $game = null;

    public function mount()
    {
        $this->game = app(DailyGameService::class)->getDailyGame();
    }


    public function render()
    {
        return view('livewire.aside', ['game' => $this->game]);
    }
}
