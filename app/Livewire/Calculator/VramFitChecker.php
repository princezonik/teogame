<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;

class VramFitChecker extends Component
{

    public $availableVram; // in GB
    public $textureSize; // in GB
    public $textureQuality = 'medium'; // Default quality
    public $result;
    public $calculatorId;

    public function mount()
    {
        $this->calculatorId = Calculator::where('slug', 'vram-fit-checker')->value('id');
    }


    public $qualityGuidelines = [
        'low' => 1, // 1 GB for low quality textures
        'medium' => 2, // 2 GB for medium quality textures
        'high' => 4, // 4 GB for high quality textures
    ];

    public function updated($property)
    {
        $this->checkFit();
    }

    public function checkFit()
    {
        $requiredVram = $this->qualityGuidelines[$this->textureQuality] * $this->textureSize;

        if ($this->availableVram >= $requiredVram) {
            $this->result = 'Fits';

        } else {
            $this->result = 'Upgrade Needed';
        }

        $this->logUsage();
    }

    private function logUsage()
    {
        CalculatorUsage::create([
            'user_id' => Auth::id(),
            'calculator_id' => $this->calculatorId,
            'inputs' => [
                'availableVram' => $this->availableVram,
                'textureSize' => $this->textureSize,
                'textureQuality' => $this->textureQuality,
            ],
            'result' => [
                'result' => $this->result,
            ],
        
        ]);
    }

    public function render()
    {
        return view('livewire.calculator.vram-fit-checker');
    }
}
