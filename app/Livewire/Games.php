<?php

namespace App\Livewire;

use App\Services\DailyGameService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Games extends Component
{
    public $games;
    public $isGameLoaded = false; // Track loading state

    public function mount(DailyGameService $dailyGameService)
    {
        $this->games = $dailyGameService->getDailyGame();

        if ($this->games) {

            // Dispatch events for Alpine or other Livewire components to react
            $this->dispatch('gameReady', 
                gameId: $this->games->id,
                slug: $this->games->slug
            )->self();
            
            $this->dispatch('setGameId', 
                gameId: $this->games->id,
                slug: $this->games->slug
            );

            $this->isGameLoaded = true;
        }else {
           
            Log::warning('❌ No daily game available for today');
        }
    }

    // method to handle game initialization
    public function loadGame($slug)
    {
        if (!$this->games || $this->games->slug !== $slug) {
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
