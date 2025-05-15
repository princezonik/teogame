<?php

namespace App\Livewire\Calculator;

use Livewire\Component;

class CraftRoi extends Component
{

    public $materialCost; // Total cost of materials (e.g., in currency)
    public $marketPrice;  // Market price of the crafted item (e.g., in currency)
    public $itemQuantity = 1; // Default to 1 item
    public $roiPercentage; // The calculated ROI percentage
    public $decision; // The decision whether crafting is worthwhile or not

    public function updated($property)
    {
        $this->calculateROI();
    }

    public function calculateROI()
    {
        if ($this->materialCost <= 0 || $this->marketPrice <= 0 || $this->itemQuantity <= 0) {
            $this->roiPercentage = null;
            $this->decision = null;
            return;
        }

        // Calculate the profit or loss per item
        $totalMaterialCost = $this->materialCost * $this->itemQuantity;
        $totalMarketValue = $this->marketPrice * $this->itemQuantity;
        
        // Calculate ROI as a percentage
        $profitOrLoss = $totalMarketValue - $totalMaterialCost;
        $this->roiPercentage = ($profitOrLoss / $totalMaterialCost) * 100;

        // Determine if crafting is profitable or not
        $this->decision = $this->roiPercentage >= 0 ? "Crafting is worthwhile" : "Buy instead (not worth crafting)";
    }
    public function render()
    {
        return view('livewire.calculator.craft-roi');
    }
}
