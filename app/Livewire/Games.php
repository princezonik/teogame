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
            //If the event might be dispatched before the Leaderboard mounts, store the game ID in the session:
            // session()->put('current_game', [
            //     'id' => $this->games->id,
            //     'slug' => $this->games->slug
            // ]);

            $this->dispatch('gameReady', 
                gameId: $this->games->id,
                slug: $this->games->slug
            )->self();
            
            $this->dispatch('setGameId', 
                gameId: $this->games->id,
                slug: $this->games->slug
            );

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
