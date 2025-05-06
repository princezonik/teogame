<div class="p-6 max-w-lg mx-auto bg-gray-900 text-white shadow-2xl rounded-2xl">
    <h2 class="text-2xl font-bold mb-2 text-center text-white">Electricity Cost Calculator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate how much your gaming habits cost in electricity each hour, day, and month based on your system's wattage and local energy rates.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">System Wattage (Watts)</label>
        <input type="number" wire:model.live="systemWattage"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" step="1">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Electricity Rate (per kWh)</label>
        <input type="number" wire:model.live="electricityRate"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" step="0.01">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Gaming Hours per Day</label>
        <input type="number" wire:model.live="gamingHoursPerDay"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" min="1">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Gaming Days per Month</label>
        <input type="number" wire:model.live="gamingDaysPerMonth"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" min="1">
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-xl text-sm space-y-1">
        <p><strong>Cost per Hour:</strong> ${{ number_format($costPerHour, 4) }}</p>
        <p><strong>Cost per Day:</strong> ${{ number_format($costPerDay, 2) }}</p>
        <p><strong>Cost per Month:</strong> ${{ number_format($costPerMonth, 2) }}</p>
    </div>
</div>
