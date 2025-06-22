<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Score;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class Leaderboard extends Component
{
    use withPagination;
    
    public $gameId;
    public $showOnlySuspicious = false;
    public $showOnlyFlagged = false;
    public $games;
    public $scoreFilter = '';
    public $movesFilter = '';


    protected $queryString = [
        'gameId' => ['except' => ''],
        'showOnlySuspicious' => ['except' => false],
        'showOnlyFlagged' => ['except' => false],
        'scoreFilter' => ['except' => ''],
        'movesFilter' => ['except' => ''],
    ];

    public function mount()
    {

        $this->games = Game::all();

        // Set initial gameId if not already selected
        $this->gameId = $this->games->first()->id ?? null;    
    }


    public function flagScore($scoreId)
    {
        $score = Score::findOrFail($scoreId);
    
        $score->update([
            'is_flagged' => !$score->is_flagged,
            'flagged_reason' => $score->is_flagged ? null : 'Suspicious activity detected',
            'flagged_at' => $score->is_flagged ? null : now(),
            'flagged_by' => $score->is_flagged ? null : Auth::id(),
        ]);

        
        
        $this->dispatch('notify', 
            type: 'success',
            message: $score->is_flagged ? 'Score has been flagged' : 'Score has been unflagged'
        );
    }

    public function updated($property)
    {
        if (in_array($property, ['gameId', 'showOnlySuspicious', 'showOnlyFlagged', 'scoreFilter', 'movesFilter'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
    
        $query = Score::with(['user', 'game'])
        ->when($this->gameId, fn($q) => $q->where('game_id', $this->gameId))
        ->when($this->showOnlySuspicious, fn($q) => $q->where(function($q) {
            $q->where('score', '>', 100)
              ->orWhere('moves', '<', 20);
        }))
        ->when($this->showOnlyFlagged, fn($q) => $q->where('is_flagged', true))
        ->when($this->scoreFilter, fn($q) => $q->where('score', '>=', $this->scoreFilter))
        ->when($this->movesFilter, fn($q) => $q->where('moves', '>=', $this->movesFilter))
        ->orderBy('score', 'desc');

        return view('livewire.admin.leaderboard', [
            'scores' => $query->orderBy('score', 'desc')->paginate(10),
        ])->layout('layouts.admin.app');
    }
}
