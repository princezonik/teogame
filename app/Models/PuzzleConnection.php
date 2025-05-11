<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuzzleConnection extends Model
{
    protected $fillable = ['puzzle_id', 'start_cell_id', 'end_cell_id', 'color'];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function startCell()
    {
        return $this->belongsTo(PuzzleCell::class, 'start_cell_id');
    }

    public function endCell()
    {
        return $this->belongsTo(PuzzleCell::class, 'end_cell_id');
    }
}
