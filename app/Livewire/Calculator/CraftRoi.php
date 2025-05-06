<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\CraftingDecision;

class CraftRoi extends Component
{

    public $material_cost;
    public $market_price;
    public $roi_percentage;
    public $recommendation;

    public function updated($field)
    {
        if (
            is_numeric($this->material_cost) &&
            is_numeric($this->market_price) &&
            $this->material_cost > 0
        ) {
            $this->calculate();
        } else {
            $this->roi_percentage = null;
            $this->recommendation = null;
        }
    }

    public function calculate()
    {
        $roi = (($this->market_price - $this->material_cost) / $this->material_cost) * 100;
        $recommendation = $roi > 0 ? 'Craft is Worth It' : 'Buy Instead';

        CraftingDecision::create([
            'material_cost' => $this->material_cost,
            'market_price' => $this->market_price,
            'roi_percentage' => $roi,
            'recommendation' => $recommendation,
        ]);

        $this->roi_percentage = $roi;
        $this->recommendation = $recommendation;
    }

    public function render()
    {
        return view('livewire.calculator.craft-roi');
    }
}
