<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Services\PuzzleGenerator;

class PuzzleController extends Controller
{
protected $generator;

    public function __construct(PuzzleGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function today(): JsonResponse
    {
        $date = Carbon::today();
        $puzzle = Puzzle::with(['cells', 'connections'])
            ->where('date', $date->toDateString())
            ->first();

        if (!$puzzle) {
            try {
                $puzzle = $this->generator->generate($date);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to generate puzzle: ' . $e->getMessage()], 500);
            }
        }

        return response()->json([
            'puzzle' => [
                'id' => $puzzle->id,
                'date' => $puzzle->date->toDateString(),
                'grid_size' => $puzzle->grid_size,
                'cells' => $puzzle->cells->map(fn($cell) => [
                    'id' => $cell->id,
                    'row' => $cell->row,
                    'col' => $cell->col,
                    'color' => $cell->color,
                ])->values(),
                'connections' => $puzzle->connections->map(fn($conn) => [
                    'start_cell_id' => $conn->start_cell_id,
                    'end_cell_id' => $conn->end_cell_id,
                    'color' => $conn->color,
                ])->values(),
            ]
        ]);
    }  
}
