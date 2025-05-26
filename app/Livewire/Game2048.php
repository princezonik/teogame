<?php

namespace App\Livewire;

use App\Events\ScoreUpdated;
use App\Models\Game;
use App\Models\Score;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Game2048 extends Component
{

    public $gameId;
    public $score = 0;
    public $moves = 0;
    public $bestMoves = null;
    public $bestScore = 0;

    public $game;

    protected $listeners = ['updateScore' => 'updateScore'];


    public function mount(Game $game)
    {
        $this->game = $game;
    }

    public function updateScore($score, $moves)
    {
        $this->score = $score;
        $this->moves = $moves;

        if (Auth::check()) {
            // For authenticated users, update the score in the database
            $scoreModel = Score::updateOrCreate(
                ['user_id' => Auth::id(), 'game_id' => $this->gameId],
                [
                    'score' => $this->score,
                    'moves' => $this->moves,
                    'best_moves' => $this->bestMoves ? min($this->bestMoves, $this->moves) : $this->moves
                ]
            );

            // Trigger the ScoreUpdated event
            event(new ScoreUpdated($scoreModel));
        }
        // For unauthenticated users, score is stored via Alpine.js in localStorage
    }

    
   

    public function render()
    {
        return view('livewire.game2048', ['isAuthenticated' => Auth::check()]);
    }
}
