<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attempt;

class LeaderboardController extends Controller
{
    public function today() {
        return Attempt::whereHas('puzzle', fn($q) => $q->whereDate('date', today()))
            ->with('user')
            ->orderBy('time_ms')
            ->limit(10)
            ->get();
    }
}
