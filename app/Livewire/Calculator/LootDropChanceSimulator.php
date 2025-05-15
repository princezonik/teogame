<?php

namespace App\Livewire\Calculator;

use Livewire\Component;

class LootDropChanceSimulator extends Component
{

    public $chancePerPull; // as percentage input (e.g. 5 for 5%)
    public $numberOfPulls;
    public $cumulativeChance;

    public function updated($property)
    {
        $this->calculateChance();
    }

    public function calculateChance()
    {
        if (is_numeric($this->chancePerPull) && is_numeric($this->numberOfPulls) && $this->chancePerPull > 0 && $this->numberOfPulls > 0) {
            $p = $this->chancePerPull / 100; // convert % to probability
            $n = $this->numberOfPulls;
            $this->cumulativeChance = round(100 * (1 - pow(1 - $p, $n)), 2); // result as %
        } else {
            $this->cumulativeChance = null;
        }
    }

    public function render()
    {
        return view('livewire.calculator.loot-drop-chance-simulator');
    }
}
