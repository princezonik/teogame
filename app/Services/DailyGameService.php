<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class DailyGameService
{

    public function getDailyGame()
    {
      
        return Cache::remember('daily_game', now()->endOfDay(), function () {
        $games = Game::all();
            
        if ($games->isEmpty()) {
            return null;
        }
        
        $dayOfYear = now()->dayOfYear;
        $gameIndex = ($dayOfYear % $games->count());
        
        // Ensure the game exists, or fallback to the first game        
        return $games[$gameIndex] ?? $games->first();
    });
    }
}