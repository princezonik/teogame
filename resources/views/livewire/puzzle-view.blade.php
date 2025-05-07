<div class="grid" style="display: grid; grid-template-columns: repeat({{ $gridSize }}, 40px); gap: 5px;">
    @foreach ($grid as $rowIndex => $row)
        @foreach ($row as $colIndex => $cell)
            <div
                class="cell"
                style="
                    width: 40px;
                    height: 40px;
                    background-color: {{ $cell['color'] ?? '#222' }};
                    border: 1px solid #555;
                    text-align: center;
                    line-height: 40px;
                    font-weight: bold;
                    color: white;
                "
                wire:click="clickCell({{ $rowIndex }}, {{ $colIndex }})"
            >
                {{ $cell['value'] ?? '' }}
            </div>
        @endforeach
    @endforeach
</div>














{{-- <div class="flex justify-center mt-5">
    <table class="border-collapse">
        <tbody>
            @for ($row = 0; $row < $gridSize; $row++)
                <tr>
                    @for ($col = 0; $col < $gridSize; $col++)
                        <td class="w-12 h-12 border border-gray-300 text-center cursor-pointer"
                            wire:click="clickCell({{ $row }}, {{ $col }})"
                            style="background-color: {{ in_array(['row' => $row, 'col' => $col], $selectedCells) ? $currentColor : 'transparent' }}">
                            {{-- Display the cell value or leave empty --}}
                            {{-- @if ($grid[$row][$col] !== null)
                                <span>{{ $grid[$row][$col] }}</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</div> --}} 

{{-- <div class="max-w-md mx-auto mt-10">
    <div class="grid" style="grid-template-columns: repeat({{ $gridSize }}, minmax(0, 1fr));">
        @foreach ($grid as $row)
            @foreach ($row as $cell)
                <div 
                    wire:click="handleCellClick({{ $cell['row'] }}, {{ $cell['col'] }})"
                    class="w-14 h-14 m-0.5 flex items-center justify-center text-white font-bold cursor-pointer rounded-lg border
                           {{ $cell['is_selected'] ? 'ring-4 ring-white' : 'ring-1 ring-gray-700' }}
                           {{ $cell['color'] ? 'bg-' . $cell['color'] . '-600' : 'bg-gray-800' }}"
                >
                    {{ $cell['value'] ?? '' }}
                </div>
            @endforeach
        @endforeach
    </div>
</div> --}}

