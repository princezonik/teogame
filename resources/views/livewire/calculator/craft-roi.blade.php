<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Crafting ROI Calculator</h2>

    <div class="mb-3">
        <label class="block">Material Cost</label>
        <input type="number" wire:model="material_cost" step="0.01" class="border px-3 py-2 rounded w-full">
    </div>

    <div class="mb-3">
        <label class="block">Market Price</label>
        <input type="number" wire:model="market_price" step="0.01" class="border px-3 py-2 rounded w-full">
    </div>

    @if(!is_null($roi_percentage))
        <div class="mt-4 p-4 border rounded bg-gray-100">
            <p><strong>ROI:</strong> {{ number_format($roi_percentage, 2) }}%</p>
            <p><strong>Recommendation:</strong> {{ $recommendation }}</p>
        </div>
    @endif
</div>
