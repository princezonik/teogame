<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Calculator;

class ToolCalculator extends Component
{

    public $slug;
    public $calculator;
    public $inputs = [];
    public $result = null;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->calculator = Calculator::where('slug', $slug)->firstOrFail();

        // Set default values for fields
        foreach ($this->calculator->fields as $field) {
            $this->inputs[$field['key']] = 0;
        }
    }

    public function calculate()
    {
        // Very simple example: each calculator defines a 'formula' callback
        // In practice, this logic could be stored in a controller or as a PHP closure

        switch ($this->slug) {
            case 'dps-to-ttk':
                $dps = $this->inputs['dps'] ?? 0;
                $hp = $this->inputs['hp'] ?? 0;
                $this->result = $dps > 0 ? round($hp / $dps, 2) . ' sec' : 'Invalid';
                break;
            case 'electricity-cost':
                $watts = $this->inputs['watts'] ?? 0;
                $hours = $this->inputs['hours'] ?? 0;
                $rate = $this->inputs['rate'] ?? 0;
                $kwh = ($watts * $hours) / 1000;
                $this->result = '$' . number_format($kwh * $rate, 2);
                break;
            default:
                $this->result = 'Calculator not defined.';
        }
    }
    public function render()
    {
        return view('livewire.tool-calculator');
    }
}
