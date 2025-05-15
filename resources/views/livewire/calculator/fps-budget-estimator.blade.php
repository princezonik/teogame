<div class="p-6 max-w-xl mx-auto bg-gray-900 text-white shadow-2xl rounded-2xl">
    <h2 class="text-2xl font-bold mb-2 text-center text-white">FPS Budget Estimator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate the average frames per second (FPS) you can expect in a specific game, based on your CPU, GPU, and resolutions.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Game Title</label>
        <input type="text" wire:model.live="gameTitle"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">CPU Model</label>
        <input type="text" wire:model.live="cpuModel"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">GPU Model</label>
        <input type="text" wire:model.live="gpuModel"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" />
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Resolution</label>
        <select wire:model="resolution"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">Select Resolution</option>
            <option value="1080p">1080p</option>
            <option value="1440p">1440p</option>
            <option value="4K">4K</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Estimated FPS</label>
        <div class="p-3 bg-gray-800 border border-gray-700 rounded-lg text-lg font-mono">
            {{ $averageFps !== null ? $averageFps . ' FPS' : 'No Data Found' }}
        </div>
    </div>
</div>
