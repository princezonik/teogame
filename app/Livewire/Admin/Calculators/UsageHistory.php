<?php

namespace App\Livewire\Admin\Calculators;

use App\Models\CalculatorUsage;
use Livewire\Component;
use Livewire\WithPagination;

class UsageHistory extends Component
{
    use WithPagination;
    
    public $searchQuery = '';

    protected $queryString = ['scoreFilter' => ['except' => ''],];

    public function updated($property)
    {
        if (in_array($property, ['searchQuery'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $usages = CalculatorUsage::with(['user', 'calculator'])
            ->when($this->searchQuery, function($query) {
                $query->whereHas('calculator', function($q) {
                    $q->where('title', 'like', '%'.$this->searchQuery.'%');
                });
            })
            ->latest()
        ->paginate(10);

        return view('livewire.admin.calculators.usage-history', [
            'usages' => $usages,
            'calculatorTypes' => CalculatorUsage::with('calculator')
                ->get()
                ->pluck('calculator.type')
                ->unique()
                ->filter()
        ])->layout('layouts.admin.app');
    }
}
