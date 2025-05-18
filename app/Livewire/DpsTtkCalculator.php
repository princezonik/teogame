<?php

namespace App\Livewire;

use Livewire\Component;

class DpsTtkCalculator extends Component
{
    public $dps;
    public $enemyHp;
    public $ttk;

    public function updated($property)
    {
        $this->calculateTtk();
    }

    public function calculateTtk()
    {
        if (is_numeric($this->dps) && is_numeric($this->enemyHp) && $this->dps > 0) {
            $this->ttk = round($this->enemyHp / $this->dps, 2);
        } else {
            $this->ttk = null;
        }
    }
    public function render()
    {
        return view('livewire.dps-ttk-calculator',);
    }
}
