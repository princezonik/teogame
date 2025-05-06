<?php

namespace App\Livewire;

use Livewire\Component;

class GamingSessionElectricityCostCalculator extends Component
{

    public $systemWattage; // in watts
    public $electricityRate; // in $ per kWh
    public $gamingHoursPerDay = 2; // Default 2 hours per day
    public $gamingDaysPerMonth = 30; // Default 30 days per month

    public $costPerHour;
    public $costPerDay;
    public $costPerMonth;

    public function updated($property)
    {
        $this->calculateCosts();
    }

    public function calculateCosts()
    {
        // Convert watts to kilowatts
        $systemKilowatts = $this->systemWattage / 1000;

        // Cost per hour
        $this->costPerHour = round($systemKilowatts * $this->electricityRate, 4);

        // Cost per day (using gaming hours per day)
        $this->costPerDay = round($this->costPerHour * $this->gamingHoursPerDay, 2);

        // Cost per month (using gaming days per month)
        $this->costPerMonth = round($this->costPerDay * $this->gamingDaysPerMonth, 2);
    }
    public function render()
    {
        return view('livewire.gaming-session-electricity-cost-calculator');
    }
}
