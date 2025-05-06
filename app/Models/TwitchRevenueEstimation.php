<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitchRevenueEstimation extends Model
{
    protected $fillable = [
        'tier1_subs',
        'bits',
        'ad_views',
        'estimated_revenue',
    ];
}
