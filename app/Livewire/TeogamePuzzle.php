<?php

namespace App\Livewire;

use App\Events\ScoreUpdated;
use Livewire\Component;
use App\Models\Puzzle;
use App\Models\Score;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;

class TeogamePuzzle extends Component
{
    public $date;
    public $puzzle;
    public $game;
    public $gridSize;
    public $cells = [];
    public $connections = [];
    public $userPaths = [];
    public $isCompleted = false;
    public $moves = 0;
    public $bestMoves = null;
    public $score = null;
    

    public function mount($date = null, $gameId = null)
    {
        $this->date = $date ?? Carbon::tomorrow()->toDateString();
        $this->game = Game::where('slug', 'teogame-puzzle')->firstOrFail();
        $gameId = $this->game->id;
        
        $this->puzzle = $gameId ? Puzzle::where('game_id', $gameId)->where('date', $this->date)->firstOrFail() : Puzzle::where('game_id', $this->game->id)->where('date', $this->date)->firstOrFail();


        $this->loadPuzzle();
        
        $this->dispatch('setGameId', [
            'gameId' => $this->game->id,
            'slug' => $this->game->slug,
        ]);

        
    }

    public function loadPuzzle()
    {
        
        try {
            
            $this->puzzle = Puzzle::where('id', $this->puzzle->id)
                ->with(['cells', 'connections'])
                ->firstOrFail();
            $this->gridSize = $this->puzzle->grid_size;

            $this->cells = $this->puzzle->cells->mapWithKeys(function ($cell) {
                if (!isset($cell->row, $cell->col, $cell->color, $cell->id) ||
                    !is_numeric($cell->row) || !is_numeric($cell->col) ||
                    empty($cell->color)) {
                    Log::warning('Invalid cell data', ['cell' => $cell->toArray()]);
                    return [];
                }
                return ["{$cell->row},{$cell->col}" => [
                    'color' => $cell->color,
                    'id' => (int) $cell->id,
                    'row' => (int) $cell->row,
                    'col' => (int) $cell->col,
                ]];
            })->filter()->toArray();

            $this->connections = $this->puzzle->connections->mapWithKeys(function ($connection) {
                $start = $this->puzzle->cells->where('id', $connection->start_cell_id)->first();
                $end = $this->puzzle->cells->where('id', $connection->end_cell_id)->first();
                if (!$start || !$end || empty($connection->color)) {
                    Log::warning('Invalid connection data', ['connection' => $connection->toArray()]);
                    return [];
                }
                return [$connection->color => [
                    'start' => [(int) $start->row, (int) $start->col],
                    'end' => [(int) $end->row, (int) $end->col],
                ]];
            })->filter()->toArray();

            // $this->resetGameState();
        } catch (\Exception $e) {
            Log::error('Failed to load puzzle: ' . $e->getMessage());
            session()->flash('error', 'Failed to load puzzle for ' . $this->date);
            $this->cells = [];
            $this->connections = [];
            $this->gridSize = 5;
        }
    }

    #[On('game-completed')]
    public function handleCompletion(array $data = [])
    {
        $validated = Validator::make($data, [
            'moves' => 'required|integer|min:0',
            'bestMoves' => 'nullable|integer|min:0',
            'score' => 'required|integer|min:0',
            'game_id' => 'required|exists:games,id',
            'timestamp' => 'required|date',
        ])->validate();

        if ($validated['game_id'] != $this->game->id) {
            Log::error('Game ID mismatch', ['received' => $validated['game_id'], 'expected' => $this->game->id]);
            return;
        }

        if (!Auth::check()) {
            return; // Guest handling is done in frontend
        }

        $newScore = $validated['score'];

        // Get current best record
        $existingScore = Score::where('user_id', Auth::id())->where('game_id', $this->game->id)->first();

        // Validate if the new score is better
        $shouldUpdate = !$existingScore || ($newScore > $existingScore->score) || ($validated['moves'] < $existingScore->moves);
        
        if (!$shouldUpdate) {
            Log::info('Score not updated', [
                'current_score' => $existingScore->score ?? null,
                'new_score' => $validated['score'],
                'current_moves' => $existingScore->moves ?? null,
                'new_moves' => $validated['moves']
            ]);

            return;
        }

        // Calculate new best moves (minimum of existing and new)
        $newBestMoves = min(
            $validated['moves'],
            $existingScore->best_moves ?? $validated['moves']
        );
        
        try {
            $score = Score::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'game_id' => $validated['game_id'],
                ],
                [
                    'score' => max($newScore, $existingScore->score ?? 0),
                    'best_moves' => $newBestMoves,
                    'moves' => $validated['moves'],
                ]
            );
            
            $this->isCompleted = true;
            $this->bestMoves = $score->best_moves;
            
            Log::info('Score saved successfully', $score->toArray());

            // $this->dispatch('scoreSaved',$score->toArray(), ['message' => 'Score saved successfully']);
            event(new ScoreUpdated($score));

        } catch (\Exception $e) {
            Log::error('Score save error', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            // $this->dispatch('showError', ['message' => 'Failed to save score']);
        }
    }


    protected function calculateScore()
    {
        
        $maxMoves = $this->gridSize * $this->gridSize * 2;
        
        return max(100, $maxMoves - ($this->moves * 10));
    }

    #[On('requestBestMoves')]
    public function loadBestMoves($gameId)
    {        

        if (Auth::check()) {
            $score = Score::where('user_id', Auth::id())
                ->where('game_id', $gameId)
                ->first();
            $this->bestMoves = $score->best_moves ?? null;
           
            $this->dispatch('best-moves-loaded', 
                gameId: $gameId, 
                bestMoves: $this->bestMoves,
            );
        }
    }

    protected function calculateBestMoves()
    {
        if (!Auth::check()) {
            return $this->bestMoves;
        }
        $currentBest = Score::where('user_id', Auth::id())
            ->where('game_id', $this->game->id)
            ->value('best_moves') ?? PHP_INT_MAX;
        return min($currentBest, $this->moves);
    }

    protected function validatePath($color, $path)
    {
        if (!isset($this->connections[$color]) || empty($path)) {
            return false;
        }

        $connection = $this->connections[$color];
        $pathStart = reset($path);
        $pathEnd = end($path);

        $connectsCorrectly = ($pathStart == $connection['start'] && $pathEnd == $connection['end']) ||
                            ($pathStart == $connection['end'] && $pathEnd == $connection['start']);

        if (!$connectsCorrectly) {
            return false;
        }

        foreach (array_slice($path, 1) as $i => $current) {
            $prev = $path[$i];
            $dx = abs($current[0] - $prev[0]);
            $dy = abs($current[1] - $prev[1]);
            if ($dx + $dy !== 1) {
                return false;
            }
        }

        return true;
    }
  
    public function render()
    {
        return view('livewire.teogame-puzzle', [
        'bestMoves' => $this->bestMoves,
    ]);
    }
}