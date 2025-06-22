<?php

namespace App\Livewire\Admin;

use App\Models\Game;
use Livewire\Component;
use App\Models\Puzzle;
use App\Services\PuzzleGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PuzzleManager extends Component
{
    public $puzzles;

    public $selectedGameId;
    public $games;
    public $currentDailyGame;
    public $todayPuzzle;
    public $generationDate;
    public $gridSize = 5;

    public function mount()
    {
        $this->games = Game::all();
        
        // Get today's game from cache or fallback to first game
        $this->currentDailyGame = Cache::get('daily_game_'.today()->format('Y-m-d'));
      
        $this->todayPuzzle = Puzzle::whereDate('date', today())->first();
        $this->generationDate = today()->format('Y-m-d');
    }

    public function generatePuzzle()
    {
        $this->validate([
            'selectedGameId' => 'required|exists:games,id',
            'generationDate' => 'required|date',
            'gridSize' => 'required|integer|min:3|max:10'
        ]);

        try {
            $date = Carbon::parse($this->generationDate);
            $game = Game::findOrFail($this->selectedGameId);

            // Check if puzzle already exists for this date
            if (Puzzle::whereDate('date', $date)->exists()) {
               
                $this->dispatch('notify', 
                    type: 'warning',
                    message: 'A puzzle already exists for this date'
                );
                return;
            }

            // Generate the puzzle
            $puzzle = app(PuzzleGenerator::class)->generate(
                $date, 
                $this->gridSize, 
                $game->id
            );

            // Update cache if generating for today
            if ($date->isToday()) {
                Cache::put('daily_game_'.today()->format('Y-m-d'), $game, now()->endOfDay());
                $this->currentDailyGame = $game;
            }

            $this->todayPuzzle = $puzzle;
            
            $this->dispatch('notify', 
                type: 'success',
                message: 'Puzzle generated successfully!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to generate puzzle: '.$e->getMessage()
            );
        }
    }

    public function regenerateTodayPuzzle()
    {
        try {
            // Delete existing puzzle if it exists
            Puzzle::whereDate('date', today())->delete();

            $game = $this->currentDailyGame ?: Game::first();
            
            $puzzle = app(PuzzleGenerator::class)->generate(
                today(), 
                $this->gridSize, 
                $game->id
            );

            $this->todayPuzzle = $puzzle;
            
            $this->dispatch('notify', 
                type: 'success',
                message: 'Puzzle regenerated successfully!'
            );

        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to regenerate puzzle: '.$e->getMessage()
            );
        }
    }

    public function setDailyGame()
    {
        $this->validate([
            'selectedGameId' => 'required|exists:games,id',
        ], [
            'selectedGameId.required' => 'Please choose a game.',
            'selectedGameId.exists' => 'The selected game is invalid.',
        ]);


        $game = Game::findOrFail($this->selectedGameId);
        
        Cache::put('daily_game_'.today()->format('Y-m-d'), $game, now()->endOfDay());
        $this->currentDailyGame = $game;
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Daily game updated successfully!'
        );
    }
    public function regeneratePuzzle($date)
    {
        try {
            $date = Carbon::parse($date)->startOfDay();

            // Delete existing puzzle for the given date
            Puzzle::whereDate('date', $date)->delete();

            $game = $this->currentDailyGame ?: Game::first();

            $puzzle = app(PuzzleGenerator::class)->generate(
                $date,
                $this->gridSize,
                $game->id
            );

            $this->todayPuzzle = $puzzle; // Optional: rename if needed, or store by date

            $this->dispatch('notify', 
                type: 'success',
                message: 'Puzzle regenerated successfully for ' . $date->format('Y-m-d')
            );

        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to regenerate puzzle: ' . $e->getMessage()
            );
        }
    }
    public function render()
    {
        return view('livewire.admin.puzzle-manager')->layout('layouts.admin.app');
    }
}
