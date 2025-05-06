<div class="flex justify-center mt-5">
    <table class="border-collapse">
        <tbody>
            @for ($row = 0; $row < $gridSize; $row++)
                <tr>
                    @for ($col = 0; $col < $gridSize; $col++)
                        <td class="w-12 h-12 border border-gray-300 text-center cursor-pointer"
                            wire:click="clickCell({{ $row }}, {{ $col }})"
                            style="background-color: {{ in_array(['row' => $row, 'col' => $col], $selectedCells) ? $currentColor : 'transparent' }}">
                            {{-- Display the cell value or leave empty --}}
                            @if ($grid[$row][$col] !== null)
                                <span>{{ $grid[$row][$col] }}</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</div>
