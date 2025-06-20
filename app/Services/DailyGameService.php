<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DailyGameService
{

    public function getDailyGame()
    {
      
        return Cache::remember('daily_game'. now()->format('Y-m-d'), now()->endOfDay(), function () {
            $games = Game::all();
                
            if ($games->isEmpty()) {
                Log::warning('No games available for daily game generation');
                return null;
            }
            
            $dayOfYear = now()->dayOfYear;
            $index = $dayOfYear % $games->count();
            // $gameIndex = $dayOfYear % $games->count();
            
            // Ensure the game exists, or fallback to the first game        
            return $games->get($index); // use get() not [$index] for safety
           
           
           
            // return $games[$gameIndex] ?? $games->first();
        });
    }
}