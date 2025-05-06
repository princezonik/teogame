<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SteamBacklog extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_backlog_hours',
        'average_weekly_playtime',
        'days_to_finish',
    ];
}
