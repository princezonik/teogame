<div class="grid grid-cols-{{ $puzzle->grid_size }} gap-1">
    
    
    @for ($y = 0; $y < $puzzle->grid_size; $y++)
        @for ($x = 0; $x < $puzzle->grid_size; $x++)
            <div
                wire:click="handleCellClick({{ $x }}, {{ $y }})"
                class="w-12 h-12 border bg-gray-100 flex items-center justify-center text-xs"
            >
                {{ $grid[$y][$x] ?? '' }}
            </div>
        @endfor
    @endfor
</div>
