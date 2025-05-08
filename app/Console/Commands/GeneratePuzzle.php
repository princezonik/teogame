<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Puzzle;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GeneratePuzzle extends Command
{
   
    /**
     * Execute the console command.
     */
    protected $signature = 'puzzle:generate';
    protected $description = 'Generate and store today\'s puzzle';

    
    public function handle()
    {
         $date = now()->addDay()->startOfDay(); // generate for next day
        $date = now()->toDateString(); // Use today for testing
        $date = Carbon::today()->toDateString();
        // $date = Carbon::tomorrow()->toDateString();

        Log::info("⏳ puzzle:generate running for $date");

        // Prevent duplicate generation
        if (Puzzle::where('date', $date)->exists()) {
            Log::info("X Puzzle for {$date} already exists.");
            return;
        }

       
        
        // Generate puzzle with random seed
        $seed = Str::random(16);
        Log::info("🧪 Using seed: $seed");
        
        $gridData = $this->generatePuzzleFromSeed($seed);
        Log::info("📦 Generated grid", ['grid' => $gridData]);

        // Calculate grid size
        $gridSize = count($gridData); // Assuming the grid is a square (n x n)
      
      
        // Verify solvability
        if (! $this->isSolvable($gridData)) {
            $this->error("Generated puzzle is unsolvable. Try again.");
            return;
        }

        // Store puzzle
        Puzzle::create([
            'date' => $date,
            'seed' => $seed,
            'data' => $gridData,
            'grid_size' => $gridSize,  // Store grid size
            'solution' => $this->solvePuzzle($gridData),
        ]);

        $this->info("Puzzle for {$date} generated successfully.");
    }

    private function generatePuzzleFromSeed($seed)
    {

        return [
            ['A', '', '', '', 'A'],
            ['', 'B', '', 'B', ''],
            ['', '', 'C', '', ''],
            ['', 'D', '', 'D', ''],
            ['C', '', '', '', ''],
        ];
    }

    private function isSolvable($grid)
    {
       
        return true;
    }

    private function solvePuzzle($grid) {
        // Step 1: Find matching pairs
        $pairs = $this->findMatchingPairs($grid);
        
        // Step 2: Solve each pair
        $solution = [];
        foreach ($pairs as $pair) {
            $path = $this->findPathBetween($grid, $pair['start'], $pair['end']);
            if ($path) {
                $solution[] = $path;
            }
        }
    
        // Step 3: Return the solution
        return json_encode($solution);
    }

    private function findMatchingPairs($grid) {
        $pairs = [];
        $letters = [];

        // Step 1: Loop through the grid and find matching pairs
        for ($y = 0; $y < count($grid); $y++) {
            for ($x = 0; $x < count($grid[$y]); $x++) {
                $letter = $grid[$y][$x];
                if ($letter && !isset($letters[$letter])) {
                    // If this letter hasn't been encountered, store its position
                    $letters[$letter] = ['start' => [$x, $y]];
                } elseif ($letter && isset($letters[$letter])) {
                    // If the letter has been encountered before, it's a pair
                    $pairs[] = [
                        'start' => $letters[$letter]['start'],
                        'end' => [$x, $y]
                    ];
                    unset($letters[$letter]); // Clear the stored pair
                }
            }
        }

        return $pairs;
    }

    private function findPathBetween($grid, $start, $end) {
        // Use a simple BFS or DFS to find a path from start to end
        $queue = [[$start]];
        $visited = [];
        $visited[implode(',', $start)] = true;

        while ($queue) {
            $path = array_shift($queue);
            $current = end($path);

            // If we reach the end point, return the path
            if ($current == $end) {
                return $path;
            }

            // Explore neighbors
            $neighbors = $this->getNeighbors($grid, $current);
            foreach ($neighbors as $neighbor) {
                if (!isset($visited[implode(',', $neighbor)])) {
                    $visited[implode(',', $neighbor)] = true;
                    $queue[] = array_merge($path, [$neighbor]);
                }
            }
        }

        return null; // No path found
    }

    private function getNeighbors($grid, $cell){
        $neighbors = [];
        $x = $cell[0];
        $y = $cell[1];
        
        // Check four possible directions: up, down, left, right
        $directions = [
            [0, -1], // up
            [0, 1],  // down
            [-1, 0], // left
            [1, 0]   // right
        ];
        
        foreach ($directions as $direction) {
            $newX = $x + $direction[0];
            $newY = $y + $direction[1];

            if ($newX >= 0 && $newX < count($grid) && $newY >= 0 && $newY < count($grid[$newX]) && $grid[$newY][$newX] === '') {
                $neighbors[] = [$newX, $newY];
            }
        }

        return $neighbors;
    }

}
