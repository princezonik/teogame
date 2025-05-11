<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class LeaderboardController extends Controller
{
   
   
    public function index() {

        //cache the leaderboard for 5 minutes (300 seconds)
        $scores = Cache::remember('leaderboard', 300, function(){ 
            return Score::with('user')->select('user_id', DB::raw('MAX(score) as score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();
        });


        // $scores = Score::with('user')->select('user_id', DB::raw('MAX(score) at score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();
        // $scores = Score::with('user')->where('game_name', 'Game1')->select('user_id', DB::raw('MAX(score) at score'))->groupBy('user_id')->orderByDesc('score')->take(20)->get();

     

        return view('leaderboard.index',compact('scores'));
    }


    //Fetch Update: When an event is received, the client fetches the updated leaderboard from /leaderboard/refresh.
    public function refresh()
    {

       //The leaderboard cache stores the top 20 scores for 5 minutes, reducing database queries for both the main view (/leaderboard) and the refresh endpoint (/leaderboard/refresh).
        $scores = Cache::remember('leaderboard', 300, function () {
            return Score::with('user')
                ->select('user_id', DB::raw('MAX(score) as score'))
                ->groupBy('user_id')
                ->orderByDesc('score')
                ->take(20)
                ->get();
        });

        // Format data for JSON response
        $formattedScores = $scores->map(function ($score) {
            return [
                'user_id' => $score->user_id,
                'user_name' => $score->user->name,
                'score' => $score->score,
            ];
        });

        return response()->json(['scores' => $formattedScores]);
    }



}
