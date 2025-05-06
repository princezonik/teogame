<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-2xl rounded-2xl">
    <h2 class="text-2xl font-bold mb-4 text-center text-white">Loot Drop Chance Simulator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate the cumulative chance of getting at least one rare item after a series of pulls.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Chance per Pull (%)</label>
        <input type="number" wire:model.live="chancePerPull"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" step="any">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Number of Pulls</label>
        <input type="number" wire:model.live="numberOfPulls"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Cumulative Chance</label>
        <div class="p-2 bg-gray-800 rounded-lg">
            {{ $cumulativeChance !== null ? $cumulativeChance . '%' : '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-xl text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">Use this simulator to predict your chances of getting at least one rare item after pulling a set number of times. Simply input your chance per pull and the number of pulls.</p>
    </div>
</div>
