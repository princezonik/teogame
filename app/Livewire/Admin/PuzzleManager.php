<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Puzzle;

class PuzzleManager extends Component
{
    public $puzzles;

    public function mount() {
        $this->puzzles = Puzzle::latest('date')->take(30)->get();
    }

    public function regenerate($date) {
        // logic to regenerate puzzle by date
    }
    public function render()
    {
        return view('livewire.admin.puzzle-manager');
    }
}
