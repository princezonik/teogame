<?php

namespace App\Livewire;

use App\Events\ScoreUpdated;
use App\Models\Game;
use App\Models\Score;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Game2048 extends Component
{

    public $gameId;
    public $score = 0;
    public $moves = 0;
    public $bestMoves = null;
    public $bestScore = 0;
    public $leaderboard1 = [];

    public $game;

    protected $listeners = ['puzzleSolved'];


    public function mount(Game $game)
    {
       
        // Handle $game as Game instance, array, or ID
        $this->game = $game instanceof Game ? $game : Game::find($game['id'] ?? $game ?? null);

        if (!$this->game) {
            Log::error('Invalid game provided to SlidingPuzzle', ['game' => $game]);
            $this->game = new Game(); // Fallback
        }

         $this->loadLeaderboard1();
    }

    public function puzzleSolved($data)
    {
        if (!Auth::check()) {
            Log::info('Non-authenticated user completed puzzle, skipping DB save');
            return;
        }

       
        $validated = Validator::make($data, [
            'moves' => 'required|integer|min:0',
            'bestMoves' => 'required|integer|min:0',
            'game_id' => 'required|exists:games,id',
            'timestamp' => 'required|date',
        ])->validate();

        $moves = $validated['moves'];
        $bestMoves = $validated['bestMoves'];
        $gameId = $validated['game_id'];
        $timestamp = $validated['timestamp'];

        if ($validated['game_id'] != $this->game->id) {
            Log::error('Game ID mismatch', ['received' => $gameId, 'expected' => $this->game->id]);
            return;
        }

        // Calculate new score
        $newScore = $this->calculateScore($moves);

        // Get existing score for this user and game
        $existingScore = Score::where('user_id', Auth::id())->where('game_id', $this->game->id)->first();

        // If existing score is higher or equal, do nothing
        if ($existingScore && $existingScore->score >= $newScore) {
            Log::info('New score is not higher. No update performed.', [
                'new_score' => $newScore,
                'existing_score' => $existingScore->score,
            ]);
            return;
        }

        try {
            $score = Score::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'game_id' => $this->game->id,
                ],
                [
                    'score' => $this->calculateScore($moves),
                    // 'best_moves' => DB::raw('LEAST(COALESCE(best_moves, 999999), ' . $validated['moves'] . ')'),
                    'moves' => $moves,
                ]
            );

            Log::info('Score saved successfully', $score->toArray());

            event(new ScoreUpdated($score));

            // Update UI
            $this->loadLeaderboard1();
            // $this->loadBestMoves();
            // $this->dispatch('update-best-moves', ['bestMoves' => $score->best_moves]);
            $this->dispatch('scoreSaved', ['message' => 'Score saved successfully']);

        } catch (\Exception $e) {
            Log::error('Score save error', ['error' => $e->getMessage(), 'data' => $data]);
            $this->dispatch('show-error', ['message' => 'Failed to save score']);
        }
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
                    // 'best_moves' => $this->bestMoves ? min($this->bestMoves, $this->moves) : $this->moves
                ]
            );

            // Trigger the ScoreUpdated event
            event(new ScoreUpdated($scoreModel));
        }
        // For unauthenticated users, score is stored via Alpine.js in localStorage
    }

    public function loadLeaderboard1()
    {
        try {
            // Subquery to get each user's latest score for the current game
            $subQuery = Score::selectRaw('MAX(id) as id')
                ->where('game_id', $this->game->id)
                ->groupBy('user_id');

            // Get the full score records for those IDs
            $this->leaderboard1 = Score::with('user')
                ->whereIn('id', $subQuery)
                ->orderByDesc('score')
                ->limit(10)
                ->get()
                ->map(function ($score) {
                    return [
                        'game_id' => $score->game_id,
                        'user_name' => $score->user->name ?? 'Unknown',
                        'score' => $score->score,
                        // 'best_moves' => $score->best_moves,
                        'time' => $score->time,
                        'difficulty' => $score->difficulty,

                    ];
                })
                ->toArray();

            Log::info('Leaderboard loaded', ['leaderboard' => $this->leaderboard1]);

        } catch (\Exception $e) {
            Log::error('Failed to load leaderboard', ['error' => $e->getMessage()]);
            $this->leaderboard1 = [];
        }
    }


    
   

    public function render()
    {
        return view('livewire.game2048', ['isAuthenticated' => Auth::check()]);
    }
}
