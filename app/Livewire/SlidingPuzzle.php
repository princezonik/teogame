<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Events\ScoreUpdated;

class SlidingPuzzle extends Component
{
    public $game;
    public $leaderboard = [];
    public $bestMoves = null;
    

    protected $listeners = ['puzzleSolved'];

    public function mount($game)
    {
        // Handle $game as Game instance, array, or ID
        $this->game = $game instanceof Game ? $game : Game::find($game['id'] ?? $game ?? null);

        if (!$this->game) {
            Log::error('Invalid game provided to SlidingPuzzle', ['game' => $game]);
            $this->game = new Game(); // Fallback
        }

        $this->loadLeaderboard();
        $this->loadBestMoves();
    }

    public function puzzleSolved($moves, $time, $difficulty, $game_id, $timestamp)
    {
        if (!Auth::check()) {
            Log::info('Non-authenticated user completed puzzle, skipping DB save', ['data' => $data]);
            return;
        }

        $data = [
            'moves' => $moves,
            'time' => $time,
            'difficulty' => $difficulty,
            'game_id' => $game_id,
            'timestamp' => $timestamp,
        ];

        // Validate data
        $validated = validator($data, [
            'moves' => 'required|integer|min:0',
            'time' => 'required|integer|min:0',
            'difficulty' => 'nullable|integer|min:3',
            'game_id' => 'required|exists:games,id',
            'timestamp' => 'required|date',
        ])->validate();

        if ($validated['game_id'] != $this->game->id) {
            Log::error('Game ID mismatch', ['received' => $validated['game_id'], 'expected' => $this->game->id]);
            return;
        }

        try {
            $score = Score::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'game_id' => $this->game->id,
                ],
                [
                    'score' => $this->calculateScore($validated['moves'], $validated['time'], $validated['difficulty'] ?? 3),
                    'best_moves' => DB::raw('LEAST(COALESCE(best_moves, 999999), ' . $validated['moves'] . ')'),
                    'difficulty' => $validated['difficulty'],
                    'moves' => $validated['moves'],
                    'time' => $validated['time'],
                ]
            );

            Log::info('Score saved successfully', $score->toArray());

            // Broadcast event
            event(new ScoreUpdated($score));

            // Update UI
            $this->loadLeaderboard();
            $this->loadBestMoves();
            $this->dispatch('update-best-moves', ['bestMoves' => $score->best_moves]);
            $this->dispatch('scoreSaved', ['message' => 'Score saved successfully']);

        } catch (\Exception $e) {
            Log::error('Score save error', ['error' => $e->getMessage(), 'data' => $data]);
            $this->dispatch('show-error', ['message' => 'Failed to save score']);
        }
    }

    
    private function calculateScore($moves, $time, $difficulty)
    {
        $baseScore = 1000;
        $difficultyMultiplier = ($difficulty ?? 3) / 3; // Default to 3 if null
        return max(100, $baseScore - ($moves * 10 * $difficultyMultiplier + $time));
    }

    public function loadLeaderboard()
    {
        try {
            $this->leaderboard = Score::with('user')
                ->where('game_id', $this->game->id)
                ->orderBy('score', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($score) {
                    return [
                        'user_name' => $score->user->name ?? 'Unknown',
                        'score' => $score->score,
                        'best_moves' => $score->best_moves,
                        'time' => $score->time,
                        'difficulty' => $score->difficulty,
                    ];
                })
                ->toArray();

            Log::info('Leaderboard loaded', ['leaderboard' => $this->leaderboard]);
        } catch (\Exception $e) {
            Log::error('Failed to load leaderboard', ['error' => $e->getMessage()]);
            $this->leaderboard = [];
        }
    }

    public function loadBestMoves()
    {
        if (Auth::check()) {
            $score = Score::where('user_id', Auth::id())
                ->where('game_id', $this->game->id)
                ->first();
            $this->bestMoves = $score->best_moves ?? null;
        }
    }

    public function render()
    {
        return view('livewire.sliding-puzzle');
    }
}
