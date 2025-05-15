<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-xl rounded-xl">
    <h2 class="text-2xl font-bold mb-4 text-center text-white">Pixel Art Cost Estimator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate the total cost of creating sprite sheets based on freelancer rates.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Select Rate Benchmark</label>
        <select wire:model.live="preset"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="custom">Custom Rate</option>
            <option value="fiverr">Fiverr (~$8/frame)</option>
            <option value="itch_io">Itch.io (~$12/frame)</option>
            <option value="twitter_avg">Twitter Avg (~$15/frame)</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Rate per Frame (USD)</label>
        <input type="number" wire:model.live="ratePerFrame" step="0.01"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500" 
            {{ $preset !== 'custom' ? 'readonly' : '' }}>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Number of Sprite Frames</label>
        <input type="number" wire:model.live="frameCount"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Estimated Total Cost</label>
        <div class="p-2 bg-gray-800 rounded-lg">
            {{ $totalCost !== null ? '$' . number_format($totalCost, 2) : '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-xl text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This tool helps estimate the total cost of pixel art sprite sheets based on freelancer rates from platforms like Fiverr, Itch.io, or Twitter. Customize your rate if needed!</p>
    </div>
</div>
