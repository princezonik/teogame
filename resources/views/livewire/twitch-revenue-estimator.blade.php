<div class="p-6 max-w-lg mx-auto bg-gray-900 text-white shadow-xl rounded-xl">
    <h2 class="text-2xl font-bold mb-4 text-center">Twitch Revenue Estimator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate your monthly Twitch earnings from subscriptions, bits, and ads based on your metrics.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Tier 1 Subs</label>
        <input type="number" wire:model.live="tier1"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Tier 2 Subs</label>
        <input type="number" wire:model.live="tier2"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Tier 3 Subs</label>
        <input type="number" wire:model.live="tier3"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Bits Cheered</label>
        <input type="number" wire:model.live="bits"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Ad Impressions (Monthly)</label>
        <input type="number" wire:model.live="adViews"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mt-4 p-4 bg-gray-800 rounded-lg">
        <p class="text-sm font-semibold">Sub Revenue:</p>
        <div class="p-2 bg-gray-700 rounded-lg">
            ${{ number_format($subRevenue, 2) }}
        </div>

        <p class="text-sm font-semibold">Bits Revenue:</p>
        <div class="p-2 bg-gray-700 rounded-lg">
            ${{ number_format($bitsRevenue, 2) }}
        </div>

        <p class="text-sm font-semibold">Ad Revenue:</p>
        <div class="p-2 bg-gray-700 rounded-lg">
            ${{ number_format($adRevenue, 2) }}
        </div>

        <hr class="my-2 border-gray-600">
        
        <p class="text-lg font-bold">Total Estimated Monthly Revenue:</p>
        <div class="p-2 bg-gray-700 rounded-lg text-xl font-bold">
            ${{ number_format($totalRevenue, 2) }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-xl text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This tool helps estimate your monthly Twitch earnings from subs, bits, and ads based on your metrics. Simply input your Tier 1, Tier 2, and Tier 3 subscribers, bits cheered, and ad impressions to see your potential revenue.</p>
    </div>
</div>
