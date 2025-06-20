<?php

namespace App\Livewire\Calculator;
use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;


use Livewire\Component;

class SteamBacklogCalculator extends Component
{
    public $backlogHours;
    public $weeklyPlayHours;
    public $daysToFinish;
    public $calculatorId;

    public function mount()
    {
        $this->calculatorId = Calculator::where('slug', 'steam-backlog-calculator')->value('id');
    }

    private function logUsage()
    {
        CalculatorUsage::create([
            'user_id' => Auth::id(),
            'calculator_id' => $this->calculatorId,
            'inputs' => [
                'backlogHours' => $this->backlogHours,
                'weeklyPlayHours' => $this->weeklyPlayHours,
            ],
            'result' => [
                'daysToFinish' => $this->daysToFinish,
            ],
           
        ]);
    }




    public function updated($property)
    {
        $this->calculateDays();
    }

    public function calculateDays()
    {
        if (is_numeric($this->backlogHours) && is_numeric($this->weeklyPlayHours) && $this->weeklyPlayHours > 0) {
            $this->daysToFinish = round(($this->backlogHours / $this->weeklyPlayHours) * 7, 1);
            $this->logUsage();
        } else {
            $this->daysToFinish = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.steam-backlog-calculator');
    }
}
