<div class="p-6  bg-gray-900 w-full text-white max-w-md shadow">
    <h1 class="text-xl font-bold text-white mb-4">Robux ↔ USD Converter</h1>

    <div class="mb-4">
        <label class="block font-semibold">Enter Robux:</label>
        <input
            type="number"
            step="any"
            wire:model.live="robux"
            id="robux"
            class="border p-2 w-full"
            placeholder="e.g. 100"
        >
    </div>
   
    
    @if(!is_null($robux) && !is_null($usd))
    
        <div class="mt-4 text-green-700 font-medium">
            value: {{ number_format($robux, 2) }} Robux ≈ ${{ number_format($usd, 2) }} USD
        </div>
    @endif
</div>
