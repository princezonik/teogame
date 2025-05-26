<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'score', 'game_id','moves', 'best_moves', 'difficulty', 'time'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
