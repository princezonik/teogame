<?php

namespace App\Livewire;

use Livewire\Component;

class VramFitChecker extends Component
{

    public $availableVram; // in GB
    public $textureSize; // in GB
    public $textureQuality = 'medium'; // Default quality
    public $result;

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
    }
    public function render()
    {
        return view('livewire.vram-fit-checker');
    }
}
