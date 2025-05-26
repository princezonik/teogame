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
    
    public function index(Request $request) {


        $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'difficulty' => 'nullable|integer|min:3|max:5' 
        ]);
        $gameId = $request->input('game_id');
        $difficulty = $request->input('difficulty');

        $cacheKey = "leaderboard:game:{$gameId}" . ($difficulty ? ":difficulty:{$difficulty}" : '');    


        //cache the leaderboard for 5 minutes (300 seconds)
        $scores = Cache::remember($cacheKey, now()->addMinutes(5), function() use ($gameId, $difficulty){ 


            $query = Score::with('user')
                ->where('game_id', $gameId)
                ->select('user_id', DB::raw('MAX(score) as max_score'), DB::raw('MIN(moves) as best_moves'))
                ->groupBy('user_id')
                ->orderByDesc('max_score')
                ->take(2);

            if ($difficulty) {
                $query->where('difficulty', $difficulty);
            }

            return $query->get();
        });

        $formatted = $scores->map(function($score) {
            return [
                'user_id' => $score->user_id,
                'user_name' => $score->user->name,
                'score' => $score->max_score,
                'best_moves' => $score->best_moves,
            ];
        });


        return response()->json([
            'scores' => $formatted,
            'meta' => [
                'game_id' => $gameId,
                'difficulty' => $difficulty,
                'cached' => Cache::has($cacheKey)
            ]
        ]);

        // return view('leaderboard.index',compact('scores'));


    }


    //Fetch Update: When an event is received, the client fetches the updated leaderboard from /leaderboard/refresh.
    public function refresh(Request $request)
    {

        $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'difficulty' => 'nullable|integer|min:3|max:5'
        ]);

        $gameId = $request->input('game_id');
        $difficulty = $request->input('difficulty');
        $cacheKey = "leaderboard:game:{$gameId}" . ($difficulty ? ":difficulty:{$difficulty}" : '');

        // Clear the cache before fetching fresh data
        Cache::forget($cacheKey);

        $query = Score::with('user')
            ->where('game_id', $gameId)
            ->select('user_id', DB::raw('MAX(score) as max_score'), DB::raw('MIN(moves) as best_moves'))
            ->groupBy('user_id')
            ->orderByDesc('max_score')
        ->take(2);


        if ($difficulty) {
            $query->where('difficulty', $difficulty);
        }

        $scores = $query->get();

        $formattedScores = $scores->map(function ($score) {
            return [
                'user_id' => $score->user_id,
                'user_name' => $score->user->name,
                'score' => $score->max_score,
                'best_moves' => $score->best_moves,
            ];
        });

       // Store fresh data in cache
        Cache::put($cacheKey, $scores, now()->addMinutes(5));

        return response()->json([
            'scores' => $formattedScores,
            'meta' => [
                'game_id' => $gameId,
                'difficulty' => $difficulty,
                'cached' => false
            ]
        ]);
    }
}
