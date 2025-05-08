<?php

namespace App\Services;

use App\Models\Puzzle;
use App\Models\PuzzleCell;
use App\Models\PuzzleConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PuzzleGenerator
{
/**
     * Generate a new solvable Path Connect puzzle.
     *
     * @param int $gridSize
     * @return Puzzle|null
     * @throws \Exception
     */
    public function generate(int $gridSize = 6, int $numColors = 4): ?Puzzle
    {
        // Use fewer colors on small grids
        $colors = array_slice(['red','blue','green','yellow','orange','purple'], 0, $numColors);

        // In-memory occupancy grid: null=free or color string if path occupies
        $occupy = array_fill(0, $gridSize, array_fill(0, $gridSize, null));

        // Store endpoints and carved paths
        $connections = [];

        // Carve a self-avoiding random path for each color
        foreach ($colors as $color) {
            // pick random start on border or anywhere
            [$r,$c] = [random_int(0, $gridSize-1), random_int(0, $gridSize-1)];
            // ensure start free
            while ($occupy[$r][$c] !== null) {
                [$r,$c] = [random_int(0, $gridSize-1), random_int(0, $gridSize-1)];
            }
            $path = [[$r,$c]];
            $occupy[$r][$c] = $color;

            // desired path length between gridSize and gridSize*2
            $length = random_int($gridSize, $gridSize * 2);
            for ($i=1; $i < $length; $i++) {
                // get neighbors
                $neighbors = [];
                foreach ([[1,0],[-1,0],[0,1],[0,-1]] as [$dr,$dc]) {
                    $nr = $r + $dr; $nc = $c + $dc;
                    if ($nr>=0 && $nr<$gridSize && $nc>=0 && $nc<$gridSize && $occupy[$nr][$nc]===null) {
                        $neighbors[] = [$nr,$nc];
                    }
                }
                if (empty($neighbors)) break; // dead end
                // choose random neighbor
                [$r,$c] = $neighbors[array_rand($neighbors)];
                $occupy[$r][$c] = $color;
                $path[] = [$r,$c];
            }

            // record endpoints: first and last
            $start = $path[0];
            $end   = $path[count($path)-1];
            $connections[] = compact('color','path','start','end');
        }

        // Now convert to cell objects in memory
        $cells = [];
        for ($r=0; $r<$gridSize; $r++) {
            for ($c=0; $c<$gridSize; $c++) {
                $cell = new PuzzleCell(['row'=>$r,'col'=>$c,'value'=>null,'color'=>null]);
                $key = "{$r}-{$c}";
                $cells[$key] = $cell;
            }
        }
        // assign endpoint colors
        foreach ($connections as $conn) {
            [$sr,$sc] = $conn['start'];
            [$er,$ec] = $conn['end'];
            $cells["{$sr}-{$sc}"]->color = $conn['color'];
            $cells["{$er}-{$ec}"]->color = $conn['color'];
        }

        // Persist puzzle, cells, connections in transaction
        return DB::transaction(function() use($gridSize,$cells,$connections) {
            $puzzle = new Puzzle();
            $puzzle->name = 'Auto Puzzle '.now()->toDateString();
            $puzzle->grid_size = $gridSize;
            $puzzle->save();

            // save cells
            foreach ($cells as $cell) {
                $cell->puzzle_id = $puzzle->id;
                $cell->save();
            }

            // save connections (only endpoints stored)
            foreach ($connections as $conn) {
                [$sr,$sc] = $conn['start'];
                [$er,$ec] = $conn['end'];
                $startCell = PuzzleCell::where('puzzle_id',$puzzle->id)->where('row',$sr)->where('col',$sc)->first();
                $endCell   = PuzzleCell::where('puzzle_id',$puzzle->id)->where('row',$er)->where('col',$ec)->first();

                $pc = new PuzzleConnection();
                $pc->puzzle_id = $puzzle->id;
                $pc->start_cell_id = $startCell->id;
                $pc->end_cell_id   = $endCell->id;
                $pc->color = $conn['color'];
                $pc->save();
            }

            Log::info("Generated puzzle {$puzzle->id}: {$gridSize}x{$gridSize} with colors: " . implode(',', array_column($connections,'color')));
            return $puzzle;
        });
    }

}
