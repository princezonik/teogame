<?php

namespace App\Livewire\Admin;

use App\Models\CalculatorUsage;
use Livewire\Component;
use Livewire\WithPagination;

class UsageHistory extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.usage-history', [
            'usages' => CalculatorUsage::with(['user', 'calculator'])
                ->latest()
                ->paginate(15),
        ])->layout('layouts.admin.app');
    }
}
