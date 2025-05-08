<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;


class PuzzleView extends Component
{

    public $gridSize;
    public $grid = [];
    public $connections = [];
    public $currentColor = null;  // The current color the user is connecting
    public $selectedCells = [];  // The list of cells the user selects
    public $puzzleId;   // Declare the public property for puzzleId

    //To initialize the puzzle grid from the database
    public function mount(){

        // This method is not complete refer to it later
       
        $puzzle = Puzzle::inRandomOrder()->first();
        
        $this->gridSize = $puzzle->grid_size;
        $this->initializeGrid($puzzle);
    }

    // Initialize the grid
    public function initializeGrid($puzzle){
      
        // Retrieve the cells for the grid from the database
        $cells = PuzzleCell::where('puzzle_id', $puzzle->id)->get();

        // Initialize an empty grid
        $this->grid = array_fill(0, $this->gridSize, array_fill(0, $this->gridSize, null));

        // Populate grid with values from the database
        foreach ($cells as $cell) {
            $this->grid[$cell->row][$cell->col] = [
                'value' => $cell->value,
                'color' => $cell->color,
                'is_selected' => false,
            ];
        }

        // Retrieve existing connections
        $this->connections = PuzzleConnection::where('puzzle_id', $puzzle->id)->get();
    }

    // Handle cell click
    // public function clickCell($row, $col){
        
    //     // Only process if a color is selected
    //     //This checks if a color has been selected (i.e., the user has clicked on a color endpoint first).
    //     //If no color is selected, the method exits early — the user can’t build a path without a starting color.
    //     if (!$this->currentColor) {
    //         return;
    //     }
        

    //     //Retrieves the current cell’s contents from the grid (which could be null, a color, a value, etc.).
    //     // Get the current cell state
    //     $currentCell = $this->grid[$row][$col];


    //     // If the cell is already part of the current connection, return
    //     //$this->selectedCells holds an array of all the cells selected in the current path.
    //     //If the clicked cell is already in that list, it returns early
    //     if (in_array(['row' => $row, 'col' => $col], $this->selectedCells)) {
    //         return;
    //     }

    //     // If the cell is empty, proceed with connecting
    //     //If the cell is empty, or is deemed a valid extension of the path (adjacent and unoccupied), continue.
    //     if ($currentCell === null || $this->isValidPath($row, $col)) {
           
    //         // Add to selected cells
    //         //Adds the newly clicked cell to the current path the player is drawing.
    //         $this->selectedCells[] = ['row' => $row, 'col' => $col];

    //         // Check if we have a valid path to form a connection
    //         if ($this->hasPathCompleted()) {
    //             $this->storeConnection();
    //         }
    //     }

    //     // If no color is active and clicked cell is an endpoint, start path
    //     if (!$this->currentColor && isset($currentCell['value'])) {
    //         $this->currentColor = $currentCell['color'];
    //         $this->selectedCells[] = ['row' => $row, 'col' => $col];
    //         $this->grid[$row][$col]['is_selected'] = true;
    //         return;
    //     }

    //     // If clicking same cell again, undo last move
    //     $last = end($this->selectedCells);
    //     if ($last === [$row, $col]) {
    //         array_pop($this->selectedCells);
    //         $this->grid[$row][$col]['is_selected'] = false;
    //         if (empty($this->selectedCells)) {
    //             $this->currentColor = null;
    //         }
    //         return;
    //     }

    //     // If a color is selected and clicked cell is adjacent and empty
    //     if ($this->currentColor && !$currentCell['value'] && !$currentCell['color']) {
    //         if ($this->isAdjacent($last, [$row, $col])) {
    //             $this->selectedCells[] = ['row' => $row, 'col' => $col];
    //             $this->grid[$row][$col]['is_selected'] = true;
    //             $this->grid[$row][$col]['color'] = $this->currentColor;
    //             return;
    //         }
    //     }

    //      // If final cell is valid endpoint (same color & adjacent), finish path
    //     if ($this->currentColor && $currentCell['color'] === $this->currentColor && isset($currentCell['value'])) {
    //         if ($this->isAdjacent($last, [$row, $col])) {
    //             $this->selectedCells[] = ['row' => $row, 'col' => $col];
    //             $this->grid[$row][$col]['is_selected'] = true;
    //             $this->finalizePath();
    //             return;
    //         }
    //     }
        
    //     if ($currentCell && $currentCell['color'] && $currentCell['color'] !== $this->currentColor) {
    //         // Cannot cross other paths
    //         return;
    //     }
    
    //     // Check adjacency if at least one cell already selected
    //     if (!empty($this->selectedCells)) {
    //         $last = end($this->selectedCells);
    //         if (!$this->isAdjacent($last, ['row' => $row, 'col' => $col])) {
    //             return;
    //         }
    //     }
    
    //     $this->selectedCells[] = ['row' => $row, 'col' => $col];
    //     $this->grid[$row][$col]['is_selected'] = true;
    //     $this->grid[$row][$col]['color'] = $this->currentColor;
    
    //     if ($this->hasPathCompleted()) {
    //         $this->finalizePath();
    //     }

    //     // Any invalid click resets the path
    //     $this->resetPath();
    // }

    // Check if the path from start to the current cell is valid (no crossing paths)
    private function isValidPath($row, $col){
        return true; 
    }

    // Check if a path is completed (user has selected start and end cells)
    private function hasPathCompleted(){
        // check if a complete path has been selected for the color
        //return count($this->selectedCells) >= 2;

        if (count($this->selectedCells) < 2) {
            return false;
        }
    
        $first = $this->selectedCells[0];
        $last = end($this->selectedCells);
    
        $firstCell = $this->grid[$first['row']][$first['col']];
        $lastCell = $this->grid[$last['row']][$last['col']];
    
        // Check both endpoints are special cells with values (A, B, etc.)
        if (!$firstCell['value'] || !$lastCell['value']) {
            return false;
        }
    
        // Check if both endpoints have the same color
        return $firstCell['color'] === $lastCell['color'];
        
    }

    // Store the connection into the database when a path is completed
    private function storeConnection(){

        // Get the first and last selected cells in the path
        $start = $this->selectedCells[0];
        $end = end($this->selectedCells);

        // Find the corresponding PuzzleCell models
        // Get cell records from DB
        $startCell = PuzzleCell::where([
            'puzzle_id' => $this->puzzleId,
            'row' => $start['row'],
            'col' => $start['col'],
        ])->first();

        $endCell = PuzzleCell::where([
            'puzzle_id' => $this->puzzleId,
            'row' => $end['row'],
            'col' => $end['col'],
        ])->first();

        if (!$startCell || !$endCell) {
            return; // Safety check
        }

        // if ($startCell && $endCell) {
        //     PuzzleConnection::create([
        //         'puzzle_id' => 1,
        //         'start_cell_id' => $startCell->id,
        //         'end_cell_id' => $endCell->id,
        //         'color' => $this->currentColor,
        //     ]);
        // }

        // Prevent duplicate connections
        $alreadyExists = PuzzleConnection::where('puzzle_id', $this->puzzleId)->where(function ($query) use ($startCell, $endCell) {
            $query->where(function ($q) use ($startCell, $endCell) {
                $q->where('start_cell_id', $startCell->id)
                ->where('end_cell_id', $endCell->id);
            })->orWhere(function ($q) use ($startCell, $endCell) {
                $q->where('start_cell_id', $endCell->id)
                ->where('end_cell_id', $startCell->id);
            });
        })->orWhere('color', $this->currentColor)->exists();

        if ($alreadyExists) {
            return; // Prevent overwriting or duplicate paths
        }

        // Create the connection
        PuzzleConnection::create([
            'puzzle_id' => $this->puzzleId,
            'start_cell_id' => $startCell->id,
            'end_cell_id' => $endCell->id,
            'color' => $this->currentColor,
        ]);

        // Reset for the next path
        $this->selectedCells = [];
        $this->currentColor = null;
    }

    // Set the current color for the path
    public function setCurrentColor($color){
        $this->currentColor = $color;
    }

    public function selectCell($row, $col){
        $cell = $this->grid[$row][$col];

        // Disallow selecting cells already filled with a color
        if (!empty($cell['color']) && !$cell['is_selected']) {
            return;
        }

        $cell['is_selected'] = true;
        $cell['color'] = $this->currentColor;

        $this->grid[$row][$col] = $cell;
        $this->selectedCells[] = $cell;
    }

    public function handleCellClick($row, $col){
    
        $cell = $this->grid[$row][$col];

        // STARTING A NEW PATH from a colored endpoint
        if (!$this->currentColor && isset($cell['value']) && $cell['value']) {
            $this->currentColor = $cell['color'];
            $this->selectedCells = [['row' => $row, 'col' => $col]];
            $this->grid[$row][$col]['is_selected'] = true;
            return;
        }

        // CONTINUE PATH to an adjacent empty cell
        if ($this->currentColor && empty($cell['value']) && empty($cell['color'])) {
            $last = end($this->selectedCells);

            if (!$last || !isset($last['row'], $last['col'])) {
                $this->resetPath();
                return;
            }

            if ($this->isAdjacent($last, ['row' => $row, 'col' => $col])) {
                $this->selectedCells[] = ['row' => $row, 'col' => $col];
                $this->grid[$row][$col]['is_selected'] = true;
                $this->grid[$row][$col]['color'] = $this->currentColor;
            }
            return;
        }

        // FINISH PATH by connecting to another same-colored endpoint
        if (
            $this->currentColor &&
            isset($cell['color'], $cell['value']) &&
            $cell['color'] === $this->currentColor &&
            $cell['value']) {
                $last = end($this->selectedCells);

            if (!$last || !isset($last['row'], $last['col'])) {
                $this->resetPath();
                return;
            }

            if ($this->isAdjacent($last, ['row' => $row, 'col' => $col])) {
                $this->selectedCells[] = ['row' => $row, 'col' => $col];
                $this->grid[$row][$col]['is_selected'] = true;
                $this->finalizePath();
            }
            return;
        }

        // INVALID MOVE
        $this->resetPath();
    }

    public function isAdjacent($a, $b){
        return abs($a['row'] - $b['row']) + abs($a['col'] - $b['col']) === 1;
    }

    public function finalizePath(){
       
        // Store in the database
        // $this->storeConnection();
       
        //lock path in grid
        foreach ($this->selectedCells as $cell) {
            $r = $cell['row'];
            $c = $cell['col'];
            $this->grid[$r][$c]['color'] = $this->currentColor;
        }

        $this->currentColor = null;
        $this->selectedCells = [];
    }

    public function resetPath(){
        foreach ($this->selectedCells as $cell) {
            $r = $cell['row'];
            $c = $cell['col'];
    
            if (!isset($this->grid[$r][$c]['value'])) {
                $this->grid[$r][$c]['color'] = null;
            }
    
            $this->grid[$r][$c]['is_selected'] = false;
        }
    
        $this->currentColor = null;
        $this->selectedCells = [];
    }

    public function undoLastStep(){

        if (empty($this->selectedCells)) {
            return;
        }

        $last = array_pop($this->selectedCells);
        $this->grid[$last['row']][$last['col']]['color'] = null;
        $this->grid[$last['row']][$last['col']]['is_selected'] = false;
    }




    //render it
    public function render()
    {
        return view('livewire.puzzle-view');
    }
}
