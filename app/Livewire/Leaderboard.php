<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attempt;


class Leaderboard extends Component
{
    public function render()
    {
        $leaders = Attempt::whereHas('puzzle', fn($q) => $q->whereDate('date', today()))
            ->with('user')
            ->orderBy('time_ms')
            ->limit(10)
            ->get();

        return view('livewire.leaderboard', compact('leaders'));
    }
}
