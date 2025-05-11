<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuzzleCell extends Model
{
  
    protected $fillable = ['puzzle_id', 'row', 'col', 'color'];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }
}
