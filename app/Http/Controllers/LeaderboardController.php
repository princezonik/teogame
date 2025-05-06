<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index() {

        $users = User::orderByDesc('score')->take(10)->get(); // top 10
        // $leaders = \App\Models\Leaderboard::with('user')->orderByDesc('score')->limit(20)->get();

        return view('leaderboard.index', compact('users'));
    }



}
