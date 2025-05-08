<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;

class PuzzleDisplay extends Component
{
    public $puzzle;
    public $puzzleId;
    public $grid;
    public $colors = ['red', 'blue', 'green', 'yellow'];
    public $selectedColor = null;
   
    public $path = [];

    public function mount($puzzleId)
    {
        // Fetch puzzle from the database
        // Set puzzleId and load the puzzle from the database
        $this->puzzleId = $puzzleId;
        $this->puzzle = Puzzle::with(['cells', 'connections'])->findOrFail($puzzleId);
        $this->grid = $this->generateGrid($this->puzzle);
    }

    public function render()
    {
        return view('livewire.puzzle-display');
    }

    public function generateGrid($puzzle)
    {
        $grid = [];

        foreach ($puzzle->cells as $cell) {
            $grid[$cell->row][$cell->col] = [
                'id' => $cell->id,
                'color' => $cell->color,
                'value' => $cell->value,
            ];
        }

        return $grid;
    }

    // Action when the user selects a color
    public function selectColor($color)
    {
        $this->selectedColor = $color;
    }

    // Handle the user interaction (e.g., connecting cells)
    public function connectCells($startCellId, $endCellId)
    {
        if ($this->selectedColor) {
            // Handle connection logic here, create a new PuzzleConnection record
            PuzzleConnection::create([
                'puzzle_id' => $this->puzzle->id,
                'start_cell_id' => $startCellId,
                'end_cell_id' => $endCellId,
                'color' => $this->selectedColor,
            ]);

            // You can update the grid here after saving the connection
            $this->grid = $this->generateGrid($this->puzzle);
        }
    }

    public function addToPath($row, $col)
    {
        if ($this->selectedColor) {
            // Add cell to path
            $this->path[] = ['row' => $row, 'col' => $col, 'color' => $this->selectedColor];

            // Update the grid to reflect the path
            $this->grid[$row][$col]['color'] = $this->selectedColor;
        }
    }

    public function resetPath()
    {
        // Reset path and clear grid color changes
        $this->path = [];
        $this->grid = $this->generateGrid($this->puzzle);
    }

    public function submitPath()
    {
        if (count($this->path) < 2) {
            return;
        }

        // Create new PuzzleConnection record
        $startCell = $this->puzzle->cells->where('row', $this->path[0]['row'])->where('col', $this->path[0]['col'])->first();
        $endCell = $this->puzzle->cells->where('row', $this->path[count($this->path) - 1]['row'])->where('col', $this->path[count($this->path) - 1]['col'])->first();

        PuzzleConnection::create([
            'puzzle_id' => $this->puzzleId,
            'start_cell_id' => $startCell->id,
            'end_cell_id' => $endCell->id,
            'color' => $this->selectedColor,
        ]);

        // Reset the path after submission
        $this->resetPath();
    }
}
