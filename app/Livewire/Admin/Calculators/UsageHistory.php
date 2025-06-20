<?php

namespace App\Livewire\Admin\Calculators;

use App\Models\CalculatorUsage;
use Livewire\Component;

class UsageHistory extends Component
{
    public function render()
    {
       return view('livewire.admin.calculators.usage-history', [
        'usages' => CalculatorUsage::with('user')->latest()->paginate(20),
    ])->layout('layouts.admin.app');
    }
}
