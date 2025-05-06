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
    public function mount()
    {

        // This method is not complete refer to it later



         // Store puzzleId in the public property
       
       
        $puzzle = Puzzle::where('id', '=', 1)->first();
        
        $this->gridSize = $puzzle->grid_size;
        $this->initializeGrid($puzzle);
    }

    // Initialize the grid
    public function initializeGrid($puzzle)
    {
        // Retrieve the cells for the grid from the database
        $cells = PuzzleCell::where('puzzle_id', $puzzle->id)->get();

        // Initialize an empty grid
        $this->grid = array_fill(0, $this->gridSize, array_fill(0, $this->gridSize, null));

        // Populate grid with values from the database
        foreach ($cells as $cell) {
            $this->grid[$cell->row][$cell->col] = $cell->value;
        }

        // Retrieve existing connections
        $this->connections = PuzzleConnection::where('puzzle_id', $puzzle->id)->get();
    }

    // Handle cell click
    public function clickCell($row, $col)
    {
        // Only process if a color is selected
        if (!$this->currentColor) {
            return;
        }

        // Get the current cell state
        $currentCell = $this->grid[$row][$col];

        // If the cell is already part of the current connection, return
        if (in_array(['row' => $row, 'col' => $col], $this->selectedCells)) {
            return;
        }

        // If the cell is empty, proceed with connecting
        if ($currentCell === null || $this->isValidPath($row, $col)) {
            // Add to selected cells
            $this->selectedCells[] = ['row' => $row, 'col' => $col];

            // Check if we have a valid path to form a connection
            if ($this->hasPathCompleted()) {
                $this->storeConnection();
            }
        }
    }

    // Check if the path from start to the current cell is valid (no crossing paths)
    private function isValidPath($row, $col)
    {

        return true; 
    }

    // Check if a path is completed (user has selected start and end cells)
    private function hasPathCompleted()
    {
        // Logic to check if a complete path has been selected for the color
        return count($this->selectedCells) >= 2; // Example condition
    }

    // Store the connection into the database when a path is completed
    private function storeConnection()
    {
        foreach ($this->selectedCells as $cell) {
            PuzzleConnection::create([
                'puzzle_id' => 1,  // Assuming puzzle ID is 1 for simplicity
                'start_cell_id' => $cell['row'], // just an example
                'end_cell_id' => $cell['col'], //  an example
                'color' => $this->currentColor, // Store the color for the connection
            ]);
        }

        // Reset for the next path
        $this->selectedCells = [];
    }

    // Set the current color for the path
    public function setCurrentColor($color)
    {
        $this->currentColor = $color;
    }

    public function selectCell($row, $col)
{
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


    //render it
    public function render()
    {
        return view('livewire.puzzle-view');
    }
}
