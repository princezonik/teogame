<div>
    <h2 class="text-2xl font-bold mb-4">{{ $calculator->name }}</h2>
    <p class="mb-4">{{ $calculator->description }}</p>

    <form wire:submit.prevent="calculate">
        @foreach($calculator->fields as $field)
            <div class="mb-3">
                <label class="block font-semibold mb-1">{{ $field['label'] }}</label>
                <input type="number" step="any" wire:model.defer="inputs.{{ $field['key'] }}" class="border p-2 w-full">
            </div>
        @endforeach
        <button type="submit" class="px-4 py-2 bg-green-600 text-white mt-2">Calculate</button>
    </form>

    @if($result !== null)
        <div class="mt-4 p-3 bg-gray-100 rounded">
            <strong>Result:</strong> {{ $result }}
        </div>
    @endif
</div>
