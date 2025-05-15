<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-xl rounded-xl">
    <h2 class="text-2xl font-bold mb-4 text-center">VRAM Fit Checker</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Check if your GPU has enough VRAM to fit the selected texture pack based on quality settings.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Available GPU VRAM (GB)</label>
        <input type="number" wire:model.live="availableVram"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Texture Pack Size (GB)</label>
        <input type="number" wire:model.live="textureSize"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Texture Quality</label>
        <select wire:model.live="textureQuality"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
    </div>

    <div class="mt-4 p-4 bg-gray-800 rounded-lg">
        <p class="text-sm font-semibold">Result:</p>
        <div class="p-2 bg-gray-700 rounded-lg">
            {{ $result ?? '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-xl text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This tool helps you check if your GPU has enough VRAM to run a specific texture pack based on selected quality. Ensure your texture pack fits within the available VRAM for smoother gameplay!</p>
    </div>
</div>
