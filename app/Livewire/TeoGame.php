<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Puzzle;
use App\Models\Attempt;
use Illuminate\Support\Facades\Auth;

class TeoGame extends Component
{
    public $puzzle;
    public $grid = [];
    public $activePath = [];
    public $completedPaths = [];
    public $activeColor;
    public $startTime;

    public function mount()
    {
        // Fetch today's puzzle
        $this->puzzle = Puzzle::whereDate('date', today())->firstOrFail();
        $this->grid = array_fill(0, $this->puzzle->grid_size, array_fill(0, $this->puzzle->grid_size, null));
        $this->startTime = now();
    }

    public function handleCellClick($x, $y){
        // Check if the clicked cell is part of an existing path or a valid starting point
        $clickedCell = [$x, $y];

        // If we're starting a new path (no active path or clicking on the first cell of an existing path)
        if (empty($this->activePath)) {
            // Find a matching color pair to start the path
            $this->startNewPath($clickedCell);
        } else {
            // Check if the clicked cell is adjacent to the last cell in the active path
            if ($this->isValidMove($clickedCell)) {
                // Continue drawing the current path
                $this->activePath[] = $clickedCell;
                // If the path is complete, finalize it
                if ($this->isPathComplete()) {
                    $this->finalizePath();
                }
            } else {
                // Invalid move, reset the path
                $this->resetActivePath();
            }
        }
    }

    public function startNewPath($clickedCell){
        // Initialize the new path, starting from the clicked cell
        $this->activePath = [$clickedCell];
    }

    public function isValidMove($clickedCell){
        // Ensure the clicked cell is adjacent to the last cell in the active path
        $lastCell = end($this->activePath);

        $xDiff = abs($lastCell[0] - $clickedCell[0]);
        $yDiff = abs($lastCell[1] - $clickedCell[1]);

        // Allow move only if the clicked cell is adjacent (horizontally or vertically)
        return ($xDiff === 1 && $yDiff === 0) || ($xDiff === 0 && $yDiff === 1);
    }

    public function isPathComplete() {
        // Check if the path connects both ends (based on the puzzle's data/solution)
        // This logic would depend on how your solution is structured (e.g., check if the full path is drawn)
        // Assuming we check for path completion after reaching the destination coordinates

        $firstCell = $this->activePath[0];
        $lastCell = end($this->activePath);

        // Assuming solution has pairs to compare
        // For now, let's assume we check if the path reaches the destination of the color pair

        return $this->isEndPoint($lastCell); // Implement the endpoint check based on your puzzle data
    }

    public function finalizePath() {
        // Finalize the path and add to the completed paths
        $color = $this->getPathColor(); // This will depend on which pair you're drawing

        $this->completedPaths[$color] = $this->activePath;
        $this->resetActivePath();
    }

    public function resetActivePath() {
        // Reset the current active path for the next click sequence
        $this->activePath = [];
    }

    public function isEndPoint($cell) {
        // Check if the given cell is the endpoint of the current color pair
        // This logic can be more complex based on how you structure the pairs in your puzzle's data
        // Example: You might check against the destination coordinates stored in the solution
        $color = $this->getPathColor();
        $destination = $this->getDestinationForColor($color); // Implement this method based on your data

        return $cell === $destination;
    }

    public function getPathColor() {
        // Retrieve the current path color based on the puzzle's data or active path
        // Example: return 'red', 'blue', etc.
        return 'red';  // This would change based on the current path being drawn
    }

    public function getDestinationForColor($color) {
        // Return the destination point for the color (from puzzle data)
        // Example: [$x, $y]
        return [4, 4];  // Placeholder; implement this based on your puzzle's solution data
    }

    public function getCellColor($x, $y){
        // Check if the cell is part of any path and return its color
    
        foreach ($this->completedPaths as $color => $path) {
            foreach ($path as $coords) {
                if ($coords === [$x, $y]) {
                    return $color; // Return the color of the completed path
                }
            }
        }

        // If the cell isn't part of a path, return transparent or other default color
        return 'transparent'; // Empty cell
    }

    public function getColorForStartPoint($clickedCell){
        foreach ($this->puzzle->data['pairs'] as $pair) {
            if ($pair['from'] === $clickedCell) {
                return $pair['color'];
            }
        }
        return null;
    }

    public function submitAttempt(){
        $isCorrect = $this->validateSolution();

        // Check if the user is authenticated or guest
        $userId = Auth::id() ?? session()->getId(); // If user is logged in, use Auth::id(), otherwise use session ID
    
        Attempt::create([
            'puzzle_id' => $this->puzzle->id,
            'user_id' => $userId,  // Store the user ID or session ID for guest users
            'moves' => json_encode($this->completedPaths),
            'time_ms' => now()->diffInMilliseconds($this->startTime),
            'is_correct' => $isCorrect,
        ]);
    
        // Provide feedback message based on correctness
        session()->flash($isCorrect ? 'success' : 'error', $isCorrect ? 'Congratulations! You solved the puzzle.' : 'Sorry, there are still incorrect paths.');
    }

    public function validateSolution(){
        foreach ($this->completedPaths as $color => $path) {
            if ($path !== $this->getColorEndPoint($color)) {
                return false; // Incorrect path
            }
        }
        return true; // All paths are correct
    }

    public function render(){
        return view('livewire.teo-game');
    }
}
