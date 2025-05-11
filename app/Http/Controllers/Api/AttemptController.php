<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;
use App\Models\Attempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AttemptController extends Controller
{
public function store(Request $request): JsonResponse
    {
        $puzzle = Puzzle::findOrFail($request->input('puzzle_id'));
        $gridSize = $puzzle->grid_size;

        $validated = $request->validate([
            'puzzle_id' => 'required|exists:puzzles,id',
            'move_list' => 'required|array',
            'move_list.*.color' => 'required|string|in:red,blue,green,yellow,purple',
            'move_list.*.path' => 'required|array|min:2',
            'move_list.*.path.*' => 'array|size:2',
            'move_list.*.path.*.0' => "integer|min:0|max:" . ($gridSize - 1),
            'move_list.*.path.*.1' => "integer|min:0|max:" . ($gridSize - 1),
            'time_ms' => 'required|integer|min:0',
        ]);

        $puzzle = Puzzle::with(['cells', 'connections'])
            ->findOrFail($validated['puzzle_id']);

        $isValid = $this->validateMoveList($puzzle, $validated['move_list']);

        $attempt = Attempt::create([
            'puzzle_id' => $validated['puzzle_id'],
            'user_id' => Auth::id(),
            'move_list' => json_encode($validated['move_list']),
            'time_ms' => $validated['time_ms'],
            'is_valid' => $isValid,
        ]);

        if (!$isValid) {
            return response()->json([
                'message' => 'Invalid solution provided',
                'attempt_id' => $attempt->id,
            ], 422);
        }

        return response()->json([
            'message' => 'Attempt submitted successfully',
            'attempt_id' => $attempt->id,
        ]);
    }

    private function validateMoveList(Puzzle $puzzle, array $moveList): bool
    {
        if (empty($moveList) && $puzzle->connections->isNotEmpty()) {
            return false;
        }

        $connectionColors = $puzzle->connections->pluck('color')->toArray();
        $moveColors = array_column($moveList, 'color');
        if (
            count($moveList) !== count($connectionColors) ||
            array_diff($connectionColors, $moveColors) ||
            array_diff($moveColors, $connectionColors)
        ) {
            return false;
        }

        $usedCells = [];

        foreach ($moveList as $move) {
            $color = $move['color'];
            $path = $move['path'];

            $connection = $puzzle->connections->firstWhere('color', $color);
            if (!$connection) {
                return false;
            }

            $startCell = $puzzle->cells->firstWhere('id', $connection->start_cell_id);
            $endCell = $puzzle->cells->firstWhere('id', $connection->end_cell_id);
            if (!$startCell || !$endCell) {
                return false;
            }

            $distance = abs($startCell->row - $endCell->row) + abs($startCell->col - $endCell->col);
            if ($distance < 2) {
                return false;
            }

            $pathStart = $path[0];
            $pathEnd = $path[count($path) - 1];
            if (
                $pathStart[0] !== $startCell->col || $pathStart[1] !== $startCell->row ||
                $pathEnd[0] !== $endCell->col || $pathEnd[1] !== $endCell->row
            ) {
                return false;
            }

            for ($i = 0; $i < count($path); $i++) {
                $current = $path[$i];
                $col = $current[0];
                $row = $current[1];

                if ($col < 0 || $col >= $puzzle->grid_size || $row < 0 || $row >= $puzzle->grid_size) {
                    return false;
                }

                $cellKey = "{$col},{$row}";
                if ($i !== 0 && $i !== count($path) - 1) {
                    if (isset($usedCells[$cellKey])) {
                        return false;
                    }
                    $usedCells[$cellKey] = $color;
                }

                if ($i > 0) {
                    $prev = $path[$i - 1];
                    $dx = abs($col - $prev[0]);
                    $dy = abs($row - $prev[1]);
                    if ($dx + $dy !== 1) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

}

