<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuzzleCell extends Model
{
    protected $fillable = [
        'row',
        'col',
        'value', 
        'color', 
       
    ];
}
