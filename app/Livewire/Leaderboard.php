<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use App\Models\Game;
use App\Models\Score;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class Leaderboard extends Component
{

    public $scores = [];
    public $gameId;
    public $game;
    public $slug;
    public $difficulty = null;
    

    // protected $listeners = [ 'echo-private:leaderboard,ScoreUpdated' => 'updateScoreFromBroadcast',];

    public function mount($gameId = null)
    {
      if (!$gameId) {
        logger()->warning('Leaderboard mounted without a gameId.');
        return;
        }

        $this->gameId = $gameId;
        $this->loadLeaderboardData();
    }

    #[On('setGameId')]
    public function handleSetGameId($gameId, $slug = null, $difficulty = null)
    {
        $this->gameId = $gameId;
        $this->slug = $slug;
        $this->difficulty = $difficulty;
        $this->loadLeaderboardData();
    }


    protected function loadLeaderboardData()
    {
        // $this->scores = Cache::remember('leaderboard', 300, function () {
        //     return Score::with('user')->where('game_id', $this->gameId)->whereIn('id', function ($query) {
        //         $query->selectRaw('MAX(id)')->from('scores')->where('game_id', $this->gameId)->groupBy('user_id');
        //     })
        //     ->orderByDesc('score')
        //     ->take(20)
        //     ->get()
        //     ->map(function ($score) {
        //         return [
        //             'user_id'    => $score->user_id,
        //             'user_name'  => $score->user->name ?? 'Unknown',
        //             'score'      => $score->score,
        //         ];
        //     })
        //     ->toArray();
        // });

        $this->scores = Score::with('user')->where('game_id', $this->gameId)->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')->from('scores')->where('game_id', $this->gameId)->groupBy('user_id');
        })->orderByDesc('score')->take(20)->get()->map(function ($score) {
            return [
                'user_id'   => $score->user_id,
                'user_name' => $score->user->name ?? 'Unknown',
                'score'     => $score->score,
            ];
        })
        ->toArray();
    }

    #[On('ScoreUpdated')]
    public function updateScoreFromBroadcast(array $data)
    {

         if ($data['game_id'] == $this->gameId) {

            
         }
        // Remove old entry for the user
        $this->scores = collect($this->scores)->reject(fn ($entry) => $entry['user_id'] === $data['user_id'])
            ->push([
                'user_id'   => $data['user_id'],
                'user_name' => $data['user_name'],
                'score'     => $data['score'],
            ])
            ->sortByDesc('score')
            ->take(20)
            ->values()
            ->toArray();
    }


    public function render()
    {
        return view('livewire.leaderboard', ['scores' => $this->scores]);
    }
}
