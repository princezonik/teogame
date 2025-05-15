<?php

namespace App\Livewire\Calculator;

use Livewire\Component;

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
        } else {
            $this->totalCost = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.pixel-art-cost-estimator');
    }
}
