<div class="p-6 max-w-lg mx-auto bg-gray-900 text-white shadow-xl rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Craft vs Buy ROI Calculator</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Compare the return on investment (ROI) for crafting an item vs buying it in the market.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Material Cost (Per Item)</label>
        <input type="number" wire:model.live="materialCost" step="0.01"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Market Price (Per Item)</label>
        <input type="number" wire:model.live="marketPrice" step="0.01"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Item Quantity (Optional)</label>
        <input type="number" wire:model.live="itemQuantity" min="1"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">ROI Percentage</label>
        <div class="p-2 bg-gray-700 rounded-lg">
            {{ $roiPercentage !== null ? number_format($roiPercentage, 2) . '%' : '—' }}
        </div>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Decision</label>
        <div class="p-2 bg-gray-700 rounded-lg">
            {{ $decision ?? '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-lg text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This tool calculates the return on investment (ROI) for crafting an item based on the cost of materials and compares it to buying the item at the market price. A positive ROI indicates crafting is a better choice, while a negative one suggests buying is more profitable.</p>
    </div>
</div>
