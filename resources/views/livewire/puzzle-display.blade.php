<div x-data="{ selectedColor: @entangle('selectedColor') }">
    selectedColor: null,
        grid: @entangle('grid'),
        path: [],
        selectColor(color) {
            this.selectedColor = color;
        },
        addToPath(row, col) {
            if (this.selectedColor) {
                this.path.push({ row, col, color: this.selectedColor });
                this.grid[row][col].color = this.selectedColor;
            }
        },
        resetPath() {
            this.path = [];
            this.grid.forEach((row, rowIndex) => {
                row.forEach((cell, colIndex) => {
                    if (!cell.color) {
                        this.grid[rowIndex][colIndex].color = null;
                    }
                });
            });
        },
        submitPath() {
            if (this.path.length < 2) return;
            @this.submitPath(); // Livewire method to save path
            this.resetPath();
        }
    }" class="puzzle-container">
    
    <!-- Color Picker -->
    <div class="color-picker">
        @foreach (['red', 'blue', 'green'] as $color)
            <button x-on:click="selectColor('{{ $color }}')" :class="{'bg-{{ $color }}': selectedColor === '{{ $color }}'}" class="color-btn"></button>
        @endforeach
    
    <div class="puzzle">
        <div class="colors">
            <button 
                x-bind:class="{ 'selected': selectedColor === 'red' }" 
                @click="selectedColor = 'red'"
                class="color-button red">
                Red
            </button>
            <button 
                x-bind:class="{ 'selected': selectedColor === 'blue' }" 
                @click="selectedColor = 'blue'"
                class="color-button blue">
                Blue
            </button>
            <button 
                x-bind:class="{ 'selected': selectedColor === 'green' }" 
                @click="selectedColor = 'green'"
                class="color-button green">
                Green
            </button>
            <button 
                x-bind:class="{ 'selected': selectedColor === 'yellow' }" 
                @click="selectedColor = 'yellow'"
                class="color-button yellow">
                Yellow
            </button>
        </div>

        <div class="grid">
            @foreach ($grid as $row => $cols)
                <div class="grid-row">
                    @foreach ($cols as $col => $cell)
                        <div 
                            class="grid-cell"
                            :class="{ 'selected': selectedColor !== null && cell.color === selectedColor }"
                            @click="if (selectedColor) { @this.connectCells({{ $cell['id'] }}, 'start-cell-id') }"
                            style="background-color: {{ $cell['color'] ?? 'white' }};">
                            {{ $cell['value'] ?? '' }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    
</div>

@push('styles')
    <style>
        .puzzle {
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        .colors {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .color-button {
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .color-button.selected {
            border: 2px solid black;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(5, 50px);
            grid-gap: 5px;
        }
        .grid-cell {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border: 1px solid #ccc;
        }
    </style>
@endpush('styles')