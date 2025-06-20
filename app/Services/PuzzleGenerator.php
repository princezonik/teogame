<?php

namespace App\Services;

use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PuzzleGenerator
{
    public function generate(Carbon $date, int $gridSize = 5, int $gameId): Puzzle
    {
        $gridSize = max(5, $gridSize);
        $seed = (int) $date->format('Ymd');
        mt_srand($seed);

        $maxAttempts = 50;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                return DB::transaction(function () use ($date, $gridSize, $seed, $attempt, $gameId) {
                    mt_srand($seed + $attempt);

                    $puzzle = Puzzle::create([
                        'name' => 'Free Flow Puzzle ' . $date->toDateString(),
                        'game_id' => $gameId,
                        'grid_size' => $gridSize,
                        'date' => $date,
                        'seed' => mt_rand(),
                        'created_at' => now('Africa/Lagos'),
                        'updated_at' => now(),
                    ]);

                    $colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
                    $maxPairs = min([
                        max(4, floor($gridSize * $gridSize / 5)),
                        count($colors)
                    ]);
                    $numPairs = $maxPairs;

                    Log::info("Generating puzzle with {$numPairs} pairs for grid size {$gridSize}");

                    $cells = [];
                    $connections = [];
                    $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, null));

                    for ($i = 0; $i < $numPairs; $i++) {
                        $color = $colors[$i % count($colors)];
                        $path = $this->generatePath($gridSize, $grid);

                        if (!$path || count($path) < 3) {
                            throw new \Exception("Path too short for color {$color}");
                        }

                        [$startRow, $startCol] = $path[0];
                        [$endRow, $endCol] = end($path);

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

                        if (!$startCell || !$endCell) {
                            throw new \Exception("Failed to create endpoints for color {$color}");
                        }

                        $connection = PuzzleConnection::create([
                            'puzzle_id' => $puzzle->id,
                            'start_cell_id' => $startCell->id,
                            'end_cell_id' => $endCell->id,
                            'color' => $color,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        if (!$connection) {
                            throw new \Exception("Failed to create connection for color {$color}");
                        }

                        $cells[] = $startCell;
                        $cells[] = $endCell;
                        $connections[] = $connection;

                        foreach ($path as [$r, $c]) {
                            $grid[$r][$c] = $color;
                        }
                    }

                    $puzzle->cells = collect($cells);
                    $puzzle->connections = collect($connections);

                    Log::info("Successfully generated {$numPairs} connections for puzzle ID {$puzzle->id}");
                    return $puzzle;
                });
            } catch (\Exception $e) {
                Log::warning("Puzzle generation attempt {$attempt} failed: " . $e->getMessage());
            }
        }

        throw new \Exception("Failed to generate a valid Free Flow puzzle after {$maxAttempts} attempts");
    }

    private function generatePath(int $gridSize, array &$grid): ?array
    {
        $maxPathAttempts = 50;

        for ($attempt = 0; $attempt < $maxPathAttempts; $attempt++) {
            $startRow = mt_rand(0, $gridSize - 1);
            $startCol = mt_rand(0, $gridSize - 1);
            if ($grid[$startRow][$startCol] !== null) {
                continue;
            }

            $path = [[$startRow, $startCol]];
            $visited = ["{$startRow},{$startCol}" => true];
            $directions = [[0, 1], [1, 0], [0, -1], [-1, 0]];

            while (count($path) < 3) {
                shuffle($directions);
                $found = false;

                foreach ($directions as [$dx, $dy]) {
                    [$lastRow, $lastCol] = end($path);
                    $newRow = $lastRow + $dx;
                    $newCol = $lastCol + $dy;
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
                    array_pop($path);
                    if (empty($path)) {
                        break;
                    }
                    unset($visited[end($path)[0] . ',' . end($path)[1]]);
                }
            }

            if (count($path) >= 3) {
                return $path;
            }
        }

        return null;
    }
}
