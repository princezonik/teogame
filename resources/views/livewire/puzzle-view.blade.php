<div class="p-4">
    <div class="grid" style="grid-template-columns: repeat({{ $gridSize }}, 3rem); display: grid; gap: 0.25rem;">
        @foreach ($grid as $rowIndex => $row)
            @foreach ($row as $colIndex => $cell)
                @php
                    $bgColor = $cell ? $cell['color'] : 'gray-800';
                    $selected = $cell && $cell['is_selected'];
                    $value = $cell['value'] ?? '';
                @endphp

                <div 
                    class="w-12 h-12 flex items-center justify-center border border-gray-600 text-white font-bold cursor-pointer rounded
                        {{ $selected ? 'ring-4 ring-white' : '' }} 
                        {{ $value ? 'text-lg' : '' }}" 
                    style="background-color: {{ $cell['color'] ?? '#2d3748' }};"
                    wire:click="handleCellClick({{ $rowIndex }}, {{ $colIndex }})"
                >
                    {{ $value }}
                </div>
            @endforeach
        @endforeach
    </div>

    <div class="mt-6 flex space-x-2">
        @php
            $availableColors = $grid 
                ? collect($grid)->flatten(1)
                    ->filter(fn($c) => $c && isset($c['value']) && $c['color'])
                    ->pluck('color')
                    ->unique()
                    ->values()
                : collect();
        @endphp

        @foreach ($availableColors as $color)
            <button 
                class="px-4 py-2 rounded text-white" 
                style="background-color: {{ $color }};"
                wire:click="setCurrentColor('{{ $color }}')"
            >
                {{ strtoupper($color) }}
            </button>
        @endforeach

        @if ($currentColor)
            <span class="ml-4 text-white">Current Color: <span style="color: {{ $currentColor }}">{{ $currentColor }}</span></span>
        @endif
    </div>
</div>
