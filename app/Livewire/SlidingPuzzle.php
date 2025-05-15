<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;

class SlidingPuzzle extends Component
{

    public $game;

    // The mount method will load the game
    public function mount(Game $game)
    {
        $this->game = $game;
    }

    // public array $tiles = [];

    // public function mount()
    // {
    //     $this->generateSolvablePuzzle();
    // }

    // public function generateSolvablePuzzle()
    // {
    //     do {
    //         $this->tiles = collect(range(0, 8))->shuffle()->toArray();
    //     } while (!$this->isSolvable($this->tiles));
    // }

    // public function move($index)
    // {
    //     $emptyIndex = array_search(0, $this->tiles);
    //     if ($this->isAdjacent($index, $emptyIndex)) {
    //         [$this->tiles[$index], $this->tiles[$emptyIndex]] = [$this->tiles[$emptyIndex], $this->tiles[$index]];
    //     }
    // }

    // private function isAdjacent($a, $b)
    // {
    //     $rowA = intdiv($a, 3); $colA = $a % 3;
    //     $rowB = intdiv($b, 3); $colB = $b % 3;
    //     return abs($rowA - $rowB) + abs($colA - $colB) === 1;
    // }

    // private function isSolvable($tiles)
    // {
    //     $inv = 0;
    //     for ($i = 0; $i < 9; $i++) {
    //         for ($j = $i + 1; $j < 9; $j++) {
    //             if ($tiles[$i] && $tiles[$j] && $tiles[$i] > $tiles[$j]) {
    //                 $inv++;
    //             }
    //         }
    //     }
    //     return $inv % 2 === 0;
    // }

    public function render()
    {
        return view('livewire.sliding-puzzle');
    }
}
