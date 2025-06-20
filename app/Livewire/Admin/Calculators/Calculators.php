<?php

namespace App\Livewire\Admin\Calculators;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Calculator;

class Calculators extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $activeCalculator = [];
    public $showEditModal = false;
    public $calculators;
    public $message;
    public $settings = [];



   
    public function openEditModal($id)
    {
        $calculator = Calculator::find($id);
        
        $this->activeCalculator = [
            'id' => $calculator->id,
            'title' => $calculator->title,
            'description' => $calculator->description,
            'settings' => $calculator->settings ?? []
        ];
        
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->activeCalculator = [];
    }

    public function toggleVisibility($id)
    {
        $calculator = Calculator::findOrFail($id);
        $calculator->is_visible = !$calculator->is_visible;
        $calculator->save();

        $this->dispatch('show-message', text: 'Visibility updated.');    
    }


    public function save()
    {
        $this->validate([
            'activeCalculator.title' => 'required|string|max:255',
            'activeCalculator.description' => 'nullable|string|max:255',
            // 'activeCalculator.settings' => 'nullable|numeric|min:0' 
        ]);
      

       
        $calculator = Calculator::findOrFail($this->activeCalculator['id']);
        $calculator->update([
            'title' => $this->activeCalculator['title'],
            'description' => $this->activeCalculator['description'],
            // 'settings' => $this->activeCalculator['settings']
        ]);

        
        $this->dispatch('refreshCalculators');
        $this->dispatch('show-message', text: 'Calculator updated successfully.');    
        $this->closeEditModal();
    }

    public function deleteCalculator($id)
    {
        Calculator::findOrFail($id)->delete();
        $this->dispatch('refreshCalculators');
        $this->dispatch('notify', type: 'success', message: 'Calculator deleted successfully!');
        $this->closeEditModal();

    }

    

    public function selectCalculator($type)
    {
        $this->activeCalculator = $type;
    }
    public function render()
    {
        return view('livewire.admin.calculators.calculators',  ['paginatedCalculators' => Calculator::paginate(10),])->layout('layouts.admin.app');
    }
}
