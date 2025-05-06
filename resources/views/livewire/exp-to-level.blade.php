<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-xl rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">EXP Needed to Reach Level N</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Calculate how much experience is required to reach a specific target level from your current level and experience.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Current Level</label>
        <input type="number" wire:model.live="currentLevel"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Current EXP into Level</label>
        <input type="number" wire:model.live="currentExp"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Target Level</label>
        <input type="number" wire:model="targetLevel"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">EXP Needed</label>
        <div class="p-2 bg-gray-700 rounded-lg">
            {{ $expNeeded !== null ? number_format($expNeeded) . ' EXP' : '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-lg text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This calculator helps you figure out how much EXP you still need to reach your target level. Enter your current level and experience, then input the level you're aiming for to find out the remaining EXP required.</p>
    </div>
</div>
