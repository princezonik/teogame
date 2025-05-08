<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PuzzleGenerator;
use Illuminate\Support\Facades\Log;
use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class GenerateDailyPuzzle extends Command
{
    protected $signature = 'puzzle:generate';
    protected $description = 'Generate tomorrow\'s daily puzzle at midnight UTC';

    public function handle()
    {
        // Set timezone to UTC
        $tomorrow = Carbon::tomorrow('UTC')->startOfDay();

        // Check if puzzle for tomorrow already exists
        if (Puzzle::where('date', $tomorrow)->exists()) {
            $this->info("Puzzle for {$tomorrow->toDateString()} already exists.");
            return;
        }

        // Generate puzzle with random seed
        $seed = random_int(1, 1000000);
        $puzzleData = $this->generatePuzzle($seed);

        // Verify solvability
        if (!$this->isSolvable($puzzleData)) {
            $this->error("Generated puzzle is not solvable. Retrying...");
            $this->handle(); // Retry if unsolvable
            return;
        }

        // Store puzzle in database
        DB::transaction(function () use ($tomorrow, $seed, $puzzleData) {
            $puzzle = Puzzle::create([
                'name' => 'Daily Puzzle ' . $tomorrow->toDateString(),
                'date' => $tomorrow,
                'seed' => $seed,
                'grid_data' => json_encode($puzzleData),
            ]);

            // Store cells
            foreach ($puzzleData['grid'] as $row => $rowData) {
                foreach ($rowData as $col => $color) {
                    if ($color) {
                        PuzzleCell::create([
                            'puzzle_id' => $puzzle->id,
                            'row' => $row,
                            'col' => $col,
                            'color' => $color,
                        ]);
                    }
                }
            }


            // Store connections
            foreach ($puzzleData['pairs'] as $pair) {
                $startCell = PuzzleCell::where('puzzle_id', $puzzle->id)
                    ->where('row', $pair['start']['y'])
                    ->where('col', $pair['start']['x'])
                    ->first();
                $endCell = PuzzleCell::where('puzzle_id', $puzzle->id)
                    ->where('row', $pair['end']['y'])
                    ->where('col', $pair['end']['x'])
                    ->first();

                PuzzleConnection::create([
                    'puzzle_id' => $puzzle->id,
                    'start_cell_id' => $startCell->id,
                    'end_cell_id' => $endCell->id,
                    'color' => $pair['color'],
                ]);
            }

        });

        $this->info("Puzzle for {$tomorrow->toDateString()} generated successfully.");
    }

    private function generatePuzzle(int $seed): array
    {
        // Seed random number generator for reproducibility
        mt_srand($seed);

        // Initialize 5x5 grid
        $grid = array_fill(0, 5, array_fill(0, 5, null));
        $colors = ['red', 'blue', 'green', 'yellow', 'purple'];
        $pairs = [];

        // Place 5 pairs of colored dots randomly
        $positions = range(0, 24);
        shuffle($positions);

        for ($i = 0; $i < 5; $i++) {
            // Get two random positions for a color pair
            $pos1 = array_shift($positions);
            $pos2 = array_shift($positions);

            // Convert to grid coordinates
            $x1 = $pos1 % 5;
            $y1 = intdiv($pos1, 5);
            $x2 = $pos2 % 5;
            $y2 = intdiv($pos2, 5);

            $color = $colors[$i];
            $grid[$y1][$x1] = $color;
            $grid[$y2][$x2] = $color;

            $pairs[] = [
                'color' => $color,
                'start' => ['x' => $x1, 'y' => $y1],
                'end' => ['x' => $x2, 'y' => $y2],
            ];
        }

        return [
            'grid' => $grid,
            'pairs' => $pairs,
        ];
    }

    private function isSolvable(array $puzzleData): bool
    {
        // Extract grid and pairs
        $grid = $puzzleData['grid'];
        $pairs = $puzzleData['pairs'];

        // Simulate solving by attempting to find non-crossing paths for each pair
        $usedCells = [];

        foreach ($pairs as $pair) {
            // $start = $pair['start'];
            // $end = $pair['end'];

            // // Use a simple BFS to find a path
            // $path = $this->findPath(
            //     $grid,
            //     $start['x'],
            //     $start['y'],
            //     $end['x'],
            //     $end['y'],
            //     $usedCells
            // );

            $path = $this->findPath(
                $grid,
                $pair['start']['x'],
                $pair['start']['y'],
                $pair['end']['x'],
                $pair['end']['y'],
                $usedCells
            );

            if (!$path) {
                return false; // No valid path found
            }

            // Mark path cells as used
            foreach ($path as [$x, $y]) {
                $usedCells["{$x},{$y}"] = true;
            }
        }

        return true;
    }

    private function findPath(array $grid, int $startX, int $startY, int $endX, int $endY, array $usedCells): ?array
    {
        $queue = [[$startX, $startY, []]];
        $visited = ["{$startX},{$startY}" => true];
        $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]]; // Down, Right, Up, Left

        while ($queue) {
            [$x, $y, $path] = array_shift($queue);

            // Reached the end
            if ($x === $endX && $y === $endY) {
                return [[$x, $y], ...$path];
            }

            // Try each direction
            foreach ($directions as [$dx, $dy]) {
                $nx = $x + $dx;
                $ny = $y + $dy;

                // Check if next position is valid
                if (
                    $nx >= 0 && $nx < 5 &&
                    $ny >= 0 && $ny < 5 &&
                    !isset($usedCells["{$nx},{$ny}"]) &&
                    !isset($visited["{$nx},{$ny}"]) &&
                    ($grid[$ny][$nx] === null || ($nx === $endX && $ny === $endY))
                ) {
                    $visited["{$nx},{$ny}"] = true;
                    $queue[] = [$nx, $ny, [[$x, $y], ...$path]];
                }
            }
        }

        return null; // No path found
    }
}
