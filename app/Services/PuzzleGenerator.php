<?php

namespace App\Services;

use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PuzzleGenerator
{
    /**
     * Generate a Free Flow puzzle for the given date with a dynamic grid size.
     *
     * @param Carbon $date The date for which to generate the puzzle
     * @param int $gridSize The size of the grid (default 5, minimum 3)
     * @return Puzzle The generated puzzle
     * @throws \Exception If a valid puzzle cannot be generated after retries
     */
    public function generate(Carbon $date, int $gridSize = 5): Puzzle
    {
        // Ensure minimum grid size for meaningful puzzles
        $gridSize = max(3, $gridSize);

        // Use date as a deterministic seed (e.g., 20250509)
        $seed = (int) $date->format('Ymd');
        mt_srand($seed);

        $maxAttempts = 50; // Limit regeneration attempts
        $attempt = 0;

        do {
            $attempt++;
            try {
                $result = DB::transaction(function () use ($date, $gridSize, $seed, $attempt) {
                    // Reset seed for consistent randomness within each attempt
                    mt_srand($seed + $attempt);

                    // Create a new puzzle record
                    $puzzle = Puzzle::create([
                        'name' => 'Free Flow Puzzle ' . $date->toDateString(),
                        'grid_size' => $gridSize,
                        'date' => $date,
                        'seed' => mt_rand(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
                    $maxPairs = min(floor($gridSize * $gridSize / 6), count($colors)); // Adjust to /6 for more connections
                    $numPairs = mt_rand(2, $maxPairs);

                    Log::info("Generating puzzle with {$numPairs} pairs for grid size {$gridSize}");

                    $cells = [];
                    $connections = [];
                    $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, null)); // Track used cells

                    // Generate paths and place endpoints
                    for ($i = 0; $i < $numPairs; $i++) {
                        $color = $colors[$i % count($colors)];
                        $path = $this->generatePath($gridSize, $grid);

                        if (!$path || count($path) < 3) { // Ensure path has at least 3 cells
                            Log::warning("Failed to generate path for color {$color}, retrying");
                            throw new \Exception("Failed to generate a path for color {$color}");
                        }

                        // Place endpoints at the start and end of the path
                        $startRow = $path[0][0];
                        $startCol = $path[0][1];
                        $endRow = $path[count($path) - 1][0];
                        $endCol = $path[count($path) - 1][1];

                        // Create start and end cells
                        $startCell = PuzzleCell::create([
                            'puzzle_id' => $puzzle->id,
                            'row' => $startRow,
                            'col' => $startCol,
                            'color' => $color,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $endCell = PuzzleCell::create([
                            'puzzle_id' => $puzzle->id,
                            'row' => $endRow,
                            'col' => $endCol,
                            'color' => $color,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $cells[] = $startCell;
                        $cells[] = $endCell;

                        // Create connection
                        $connection = PuzzleConnection::create([
                            'puzzle_id' => $puzzle->id,
                            'start_cell_id' => $startCell->id,
                            'end_cell_id' => $endCell->id,
                            'color' => $color,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $connections[] = $connection;

                        // Mark the path on the grid to prevent crossings
                        foreach ($path as $point) {
                            $grid[$point[0]][$point[1]] = $color;
                        }
                    }

                    // Convert cells and connections to Collections
                    $puzzle->cells = collect($cells);
                    $puzzle->connections = collect($connections);

                    Log::info("Successfully generated {$numPairs} connections for puzzle ID {$puzzle->id}");
                    return $puzzle;
                });

                Log::info('Free Flow puzzle generated successfully for ' . $date->toDateString());
                return $result;
            } catch (\Exception $e) {
                Log::warning('Puzzle generation attempt ' . $attempt . ' failed: ' . $e->getMessage());
            }
        } while ($attempt < $maxAttempts);

        throw new \Exception('Failed to generate a valid Free Flow puzzle after ' . $maxAttempts . ' attempts');
    }

    /**
     * Generate a path on the grid that doesn't cross existing paths.
     *
     * @param int $gridSize The size of the grid
     * @param array $grid The grid tracking used cells
     * @return array|null The generated path as an array of [row, col] coordinates, or null if failed
     */
    private function generatePath(int $gridSize, array &$grid): ?array
    {
        $attempts = 0;
        $maxPathAttempts = 50;

        while ($attempts < $maxPathAttempts) {
            $attempts++;

            // Randomly pick a starting point
            $startRow = mt_rand(0, $gridSize - 1);
            $startCol = mt_rand(0, $gridSize - 1);
            if ($grid[$startRow][$startCol] !== null) {
                continue; // Start cell is occupied
            }

            $path = [[$startRow, $startCol]];
            $visited = ["{$startRow},{$startCol}" => true];
            $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]]; // Right, down, left, up

            // Grow the path until it's at least 3 cells long
            while (count($path) < 3) {
                shuffle($directions); // Randomize direction
                $found = false;

                foreach ($directions as [$dx, $dy]) {
                    $newRow = $path[count($path) - 1][0] + $dx;
                    $newCol = $path[count($path) - 1][1] + $dy;
                    $key = "{$newRow},{$newCol}";

                    if (
                        $newRow >= 0 && $newRow < $gridSize &&
                        $newCol >= 0 && $newCol < $gridSize &&
                        !isset($visited[$key]) &&
                        $grid[$newRow][$newCol] === null
                    ) {
                        $path[] = [$newRow, $newCol];
                        $visited[$key] = true;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    // Backtrack if no valid direction
                    array_pop($path);
                    if (empty($path)) {
                        break; // Cannot extend, start over
                    }
                    $lastKey = "{$path[count($path) - 1][0]},{$path[count($path) - 1][1]}";
                    unset($visited[$lastKey]);
                }
            }

            if (count($path) >= 3) {
                return $path; // Path successfully generated
            }
        }

        return null; // Failed to generate a path
    }
}