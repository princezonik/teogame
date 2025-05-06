<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attempt;
use App\Models\Puzzle;
use Illuminate\Support\Facades\Auth;

class PlayPuzzle extends Component
{

    public Puzzle $puzzle;
    public $moves = [], $startTime, $endTime;

    public function mount() {
        $this->puzzle = Puzzle::whereDate('date', today())->firstOrFail();
        $this->startTime = now();
    }

    public function submit(array $moves) {
        $this->endTime = now();
        $duration = $this->endTime->diffInMilliseconds($this->startTime);

        // Validate solution externally or here...

        Attempt::create([
            'user_id' => Auth::id(),
            'puzzle_id' => $this->puzzle->id,
            'moves' => $moves,
            'time_ms' => $duration,
        ]);

        session()->flash('message', 'Attempt submitted!');
    }

    public function render()
    {
        return view('livewire.play-puzzle');
    }
}
