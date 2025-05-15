<?php

namespace App\Livewire\Calculator;

use Livewire\Component;

class SteamBacklogCalculator extends Component
{
    public $backlogHours;
    public $weeklyPlayHours;
    public $daysToFinish;


    public function updated($property)
    {
        $this->calculateDays();
    }

    public function calculateDays()
    {
        if (is_numeric($this->backlogHours) && is_numeric($this->weeklyPlayHours) && $this->weeklyPlayHours > 0) {
            $this->daysToFinish = round(($this->backlogHours / $this->weeklyPlayHours) * 7, 1);
        } else {
            $this->daysToFinish = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.steam-backlog-calculator');
    }
}
