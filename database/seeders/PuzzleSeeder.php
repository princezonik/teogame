<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;


class PuzzleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $gridSize =6;
        $colors = ['red', 'blue', 'green', 'yellow'];
        $puzzle = Puzzle::create([
            'name' => 'Generated Puzzle',
            'grid_size' => $gridSize,
        ]);

        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, null));

        foreach ($colors as $color) {
            $path = $this->placePath($grid, $gridSize);
            if (!$path) continue;

            $value = strtoupper(substr($color, 0, 1));

            foreach ($path as $index => [$row, $col]) {
                PuzzleCell::create([
                    'puzzle_id' => $puzzle->id,
                    'row' => $row,
                    'col' => $col,
                    'color' => ($index === 0 || $index === count($path) - 1) ? $color : null,
                    'value' => ($index === 0 || $index === count($path) - 1) ? $value : null,
                ]);
                $grid[$row][$col] = $color;
            }
        }

        // Fill remaining empty cells
        for ($row = 0; $row < $gridSize; $row++) {
            for ($col = 0; $col < $gridSize; $col++) {
                if (!$grid[$row][$col]) {
                    PuzzleCell::create([
                        'puzzle_id' => $puzzle->id,
                        'row' => $row,
                        'col' => $col,
                        'color' => null,
                        'value' => null,
                    ]);
                }
            }
        }
    }

    private function placePath(&$grid, $gridSize)
    {
        $attempts = 100;
        while ($attempts--) {
            $start = [$this->randCoord($gridSize), $this->randCoord($gridSize)];
            $end = [$this->randCoord($gridSize), $this->randCoord($gridSize)];

            if ($start === $end || $grid[$start[0]][$start[1]] || $grid[$end[0]][$end[1]]) continue;

            $path = [];
            if ($this->findPath($start, $end, $grid, $gridSize, [], $path)) {
                return $path;
            }
        }
        return null;
    }

    private function findPath($current, $end, &$grid, $gridSize, $visited, &$path)
    {
        [$row, $col] = $current;
        if ($row < 0 || $col < 0 || $row >= $gridSize || $col >= $gridSize) return false;
        if ($grid[$row][$col]) return false;
        if (isset($visited["$row,$col"])) return false;

        $visited["$row,$col"] = true;
        $path[] = [$row, $col];

        if ($current === $end) return true;

        $dirs = [[0,1],[1,0],[0,-1],[-1,0]];
        shuffle($dirs);

        foreach ($dirs as [$dr, $dc]) {
            if ($this->findPath([$row + $dr, $col + $dc], $end, $grid, $gridSize, $visited, $path)) {
                return true;
            }
        }

        array_pop($path); // backtrack
        return false;
    }

    private function randCoord($max)
    {
        return rand(0, $max - 1);
    }
}
