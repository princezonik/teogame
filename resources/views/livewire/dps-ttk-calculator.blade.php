<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-2xl rounded-2xl">
    <h2 class="text-2xl font-bold mb-2 text-center text-white">DPS → TTK Calculator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Enter a weapon’s Damage Per Second and enemy health to calculate the time to kill (TTK). Useful for comparing weapons in shooters and RPGs.
    </p>

    <div class="mb-5">
        <label class="block text-sm font-semibold mb-1">Weapon DPS</label>
        <input type="number" wire:model.live="dps" step="any"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
    </div>

    <div class="mb-5">
        <label class="block text-sm font-semibold mb-1">Enemy HP</label>
        <input type="number" wire:model.live="enemyHp" step="any"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Time to Kill (TTK)</label>
        <div class="p-3 bg-gray-800 border border-gray-700 rounded-lg text-lg font-mono">
            {{ $ttk !== null ? $ttk . ' seconds' : '—' }}
        </div>
    </div>
</div>
