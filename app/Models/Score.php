<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'score', 'game_id','moves', 'best_moves', 'difficulty', 'time', 'is_flagged', 'flagged_reason', 'flagged_at', 'flagged_by'];
   
    protected $casts = ['is_flagged' => 'boolean','flagged_at' => 'datetime',];

    public function flaggedBy()
    {
        return $this->belongsTo(User::class, 'flagged_by');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
