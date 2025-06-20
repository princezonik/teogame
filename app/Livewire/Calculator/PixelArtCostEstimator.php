<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;

class PixelArtCostEstimator extends Component
{

    public $frameCount;
    public $ratePerFrame = 10;
    public $totalCost;

    public $preset = 'custom';
    public $presets = [
        'custom' => null,
        'fiverr' => 8,
        'itch_io' => 12,
        'twitter_avg' => 15,
    ];

    public $calculatorId;

    public function mount()
    {
        $this->calculatorId = Calculator::where('slug', 'pixel-art-cost-estimator')->value('id');
    }

    public function updated($property)
    {
        if ($property === 'preset' && $this->preset !== 'custom') {
            $this->ratePerFrame = $this->presets[$this->preset];
        }

        $this->calculate();
    }

    public function calculate()
    {
        if (is_numeric($this->frameCount) && is_numeric($this->ratePerFrame)) {
            $this->totalCost = $this->frameCount * $this->ratePerFrame;

            CalculatorUsage::create([
                'user_id' => Auth::id(),  // will be null for guests
                'calculator_id' => $this->calculatorId,
                'inputs' => [
                    'preset' => $this->preset,
                    'ratePerFrame' => $this->ratePerFrame,
                    'frameCount' => $this->frameCount,
                ],
                'result' => ['totalCost' => $this->totalCost],
                
            ]);
        } else {
            $this->totalCost = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.pixel-art-cost-estimator');
    }
}
