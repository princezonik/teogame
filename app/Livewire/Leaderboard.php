<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use App\Models\Attempt;
use App\Models\Score;

class Leaderboard extends Component
{

    public $scores;

    protected $listeners = ['echo-private:leaderboard.*,ScoreUpdated' => 'updateScoreFromBroadcast',];

    public function mount()
    {
        $this->scores = Cache::remember('leaderboard', 300, function () {
            return Score::with('user')->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')->from('scores')->groupBy('user_id');
            })
            ->orderByDesc('score')
            ->take(20)
            ->get()
            ->map(function ($score) {
                return [
                    'user_id'    => $score->user_id,
                    'user_name'  => $score->user->name ?? 'Unknown',
                    'score'      => $score->score,
                ];
            })
            ->toArray();
        });
    }

    public function updateScoreFromBroadcast(array $data)
    {
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

    // public function index() {

       


    //     // $scores = Score::with('user')->select('user_id', DB::raw('MAX(score) at score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();
    //     // $scores = Score::with('user')->where('game_name', 'Game1')->select('user_id', DB::raw('MAX(score) at score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();

     

    //     return view('leaderboard.index',compact('scores'));
    // }
    public function render()
    {
        return view('livewire.leaderboard', ['scores' => $this->scores]);
    }
}
