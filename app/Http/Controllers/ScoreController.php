<?php

namespace App\Http\Controllers;

use App\Events\ScoreUpdated;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ScoreController extends Controller
{
      public function store(Request $request)
    {
        $request->validate([
            'score' => 'required|integer|min:0',
            'title' => 'nullable|string|max:255',
            'game_id' => 'required|integer|exists:games,id',
        ]);

        //Cache Invalidation: When a new score is saved, the cache is cleared with. The next request rebuilds the cache with fresh data.
        
        $score = Score::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
            'score' => $request->score,
            'title' => $request->title,
        ]);

        

        //check if score is in top 20
        // Invalidate the leaderboard cache if this score is in the top 20
        $topScores = Score::select('user_id', DB::raw('MAX(score) as score'))
            ->groupBy('user_id')
            ->orderByDesc('score')
            ->take(20)
            ->pluck('score');

        if ($topScores->isEmpty() || $score->score >= $topScores->min()) {
            Cache::forget('leaderboard');
        }

        // Dispatch event
        //  Real-Time Updates: The ScoreUpdated event triggers a client-side refresh, ensuring users see the updated leaderboard without manually reloading the page.

        event(new ScoreUpdated($score));

        return response()->json([
            'message' => 'Score saved successfully',
            'data' => [
                'user_id' => $score->user_id,
                'game_id' => $score->game_id,
                'user_name' => $score->user->name,
                'score' => $score->score,
            ]
        ]);
    }

}
