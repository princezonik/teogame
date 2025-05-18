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

    public function mount()
    {
        // $this->scores = Score::orderBy('value', 'desc')->take(10)->get();
         //cache the leaderboard for 5 minutes (300 seconds)
        $this->scores = Cache::remember('leaderboard', 300, function(){ 
            return Score::with('user')->select('user_id', DB::raw('MAX(score) as score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();
        });
    }

    // public function index() {

       


    //     // $scores = Score::with('user')->select('user_id', DB::raw('MAX(score) at score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();
    //     // $scores = Score::with('user')->where('game_name', 'Game1')->select('user_id', DB::raw('MAX(score) at score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();

     

    //     return view('leaderboard.index',compact('scores'));
    // }
    public function render()
    {
        // $leaders = Attempt::whereHas('puzzle', fn($q) => $q->whereDate('date', today()))
        //     ->with('user')
        //     ->orderBy('time_ms')
        //     ->limit(10)
        //     ->get();

        return view('livewire.leaderboard', ['scores' => $this->scores]);
    }
}
