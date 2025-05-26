<?php

namespace App\Livewire;

use App\Services\DailyGameService;
use Livewire\Component;

class Games extends Component
{
    public $games;
    public $isGameLoaded = false; // Track loading state

    public function mount(DailyGameService $dailyGameService)
    {
        $this->games = $dailyGameService->getDailyGame();

        if ($this->games) {
            $this->dispatch('gameReady', 
                gameId: $this->games->id,
                slug: $this->games->slug
            )->self();
            $this->dispatch('setGameId', 
                gameId: $this->games->id,
                slug: $this->games->slug
            ); // New event for global gameId
            $this->isGameLoaded = true;
        }
    }

    // method to handle game initialization
    public function loadGame($slug)
    {
        if (!$this->games) {
            return;
        }

        $this->isGameLoaded = true;
        
        // Dispatch event with game ID to parent components
        $this->dispatch('game-loaded', 
            gameId: $this->games->id,
            slug: $this->games->slug
        );
    }
    

    public function render()
    {
        return view('livewire.games');
    }
}
