<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;


class TwitchRevenueEstimator extends Component
{

    public $tier1 = 0;
    public $tier2 = 0;
    public $tier3 = 0;
    public $bits = 0;
    public $adViews = 0;

    public $subRevenue;
    public $bitsRevenue;
    public $adRevenue;
    public $totalRevenue;

    public $calculatorId;

    public function mount()
    {
        $this->calculatorId = Calculator::where('slug', 'twitch-revenue-estimator')->value('id');
    }

    public function updated($property)
    {
        $this->calculateRevenue();
    }


    public function calculateRevenue()
    {
        $tier1Rate = 2.50;
        $tier2Rate = 5.00;
        $tier3Rate = 12.50;
        $bitRate = 0.01;
        $adCPM = 3.50; // per 1,000 views

        $this->subRevenue = $this->tier1 * $tier1Rate + $this->tier2 * $tier2Rate + $this->tier3 * $tier3Rate;
        $this->bitsRevenue = $this->bits * $bitRate;
        $this->adRevenue = ($this->adViews / 1000) * $adCPM;

        $this->totalRevenue = round($this->subRevenue + $this->bitsRevenue + $this->adRevenue, 2);
        $this->logUsage();
    }

    private function logUsage()
    {
        CalculatorUsage::create([
            'user_id' => Auth::id(),
            'calculator_id' => $this->calculatorId,
            'inputs' => [
                'tier1' => $this->tier1,
                'tier2' => $this->tier2,
                'tier3' => $this->tier3,
                'bits' => $this->bits,
                'adViews' => $this->adViews,
            ],
            'result' => [
                'subRevenue' => $this->subRevenue,
                'bitsRevenue' => $this->bitsRevenue,
                'adRevenue' => $this->adRevenue,
                'totalRevenue' => $this->totalRevenue,
            ],
           
        ]);
    }

    public function render()
    {
        return view('livewire.calculator.twitch-revenue-estimator');
    }
}
