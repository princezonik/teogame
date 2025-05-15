<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-xl rounded-xl">
    <h2 class="text-2xl font-bold mb-4 text-center text-white">Ping to Frame Delay Gauge</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate the number of missed frames based on your ping and frame rate.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Ping (ms)</label>
        <input type="number" wire:model.live="pingMs"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" step="any">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Frame Rate (FPS)</label>
        <input type="number" wire:model.live="frameRate"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="60" step="any">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Estimated Missed Frames</label>
        <div class="p-2 bg-gray-800 rounded-lg">
            {{ $missedFrames !== null ? $missedFrames . ' frames' : '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-xl text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This tool estimates how many frames are missed due to network latency. A higher ping or lower frame rate leads to more missed frames. Enter your ping (ms) and your game's frame rate (FPS) to calculate the impact.</p>
    </div>
</div>
