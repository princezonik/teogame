<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TeogamePuzzle extends Component
{

    public $date;
    public $puzzle;
    public $gridSize;
    public $cells;
    public $connections;
    public $userPaths = [];
    public $isCompleted = false;

    protected $listeners = ['updatePath' => 'updateUserPath', 'resetPuzzle' => 'resetPuzzle'];

    public function mount($date = null)
    {
        $this->date = $date ?? Carbon::today()->toDateString();
        $this->loadPuzzle();
    }

    public function loadPuzzle()
    {
        try {
            $this->puzzle = Puzzle::where('date', $this->date)->with(['cells', 'connections'])->firstOrFail();
            $this->gridSize = $this->puzzle->grid_size;

            // Map cells with strict validation
            $this->cells = $this->puzzle->cells->mapWithKeys(function ($cell) {
                if (!isset($cell->row, $cell->col, $cell->color, $cell->id) ||
                    !is_numeric($cell->row) || !is_numeric($cell->col) ||
                    empty($cell->color)) {
                    Log::warning('Invalid cell data', ['cell' => $cell->toArray()]);
                    return [];
                }
                $key = "{$cell->row},{$cell->col}";
                return [$key => [
                    'color' => $cell->color,
                    'id' => (int) $cell->id,
                    'row' => (int) $cell->row,
                    'col' => (int) $cell->col
                ]];
            })->filter()->toArray();

            // Map connections with validation
            $this->connections = $this->puzzle->connections->mapWithKeys(function ($connection) {
                $start = $this->puzzle->cells->where('id', $connection->start_cell_id)->first();
                $end = $this->puzzle->cells->where('id', $connection->end_cell_id)->first();
                if (!$start || !$end || empty($connection->color)) {
                    Log::warning('Invalid connection data', ['connection' => $connection->toArray()]);
                    return [];
                }
                return [$connection->color => [
                    'start' => [(int) $start->row, (int) $start->col],
                    'end' => [(int) $end->row, (int) $end->col]
                ]];
            })->filter()->toArray();

            $this->userPaths = [];
            $this->isCompleted = false;

            Log::info('Cells data:', ['cells' => $this->cells]);
            Log::info('Connections data:', ['connections' => $this->connections]);
            Log::info('Grid size:', ['gridSize' => $this->gridSize]);
        } catch (\Exception $e) {
            Log::error('Failed to load puzzle: ' . $e->getMessage());
            session()->flash('error', 'Failed to load puzzle for ' . $this->date);
            $this->cells = [];
            $this->connections = [];
            $this->gridSize = 5;
        }
    }

    public function updateUserPath($color, $path)
    {
        $this->userPaths[$color] = $path;
        $this->checkCompletion();
    }

    public function checkCompletion()
    {
        foreach ($this->connections as $color => $connection) {
            if (!isset($this->userPaths[$color])) {
                $this->isCompleted = false;
                return;
            }
            $path = $this->userPaths[$color];
            if (empty($path)) {
                $this->isCompleted = false;
                return;
            }
            $start = $connection['start'];
            $end = $connection['end'];
            $pathStart = reset($path);
            $pathEnd = end($path);
            if (
                !($pathStart[0] == $start[0] && $pathStart[1] == $start[1] &&
                  $pathEnd[0] == $end[0] && $pathEnd[1] == $end[1]) &&
                !($pathStart[0] == $end[0] && $pathStart[1] == $end[1] &&
                  $pathEnd[0] == $start[0] && $pathEnd[1] == $start[1])
            ) {
                $this->isCompleted = false;
                return;
            }
            for ($i = 1; $i < count($path); $i++) {
                $dx = abs($path[$i][0] - $path[$i-1][0]);
                $dy = abs($path[$i][1] - $path[$i-1][1]);
                if ($dx + $dy != 1) {
                    $this->isCompleted = false;
                    return;
                }
            }
        }
        $this->isCompleted = true;
    }

    public function markAsCompleted()
    {
        $this->isCompleted = true;
        $this->dispatch('puzzle-completed');
    }

    
    public function resetPuzzle()
    {
        $this->userPaths = [];
        $this->isCompleted = false;
        $this->dispatch('puzzle-reset');
    }
    public function render()
    {
        return view('livewire.teogame-puzzle');
    }
}
