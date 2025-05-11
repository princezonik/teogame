@props(['puzzle', 'error'])

<div class="p-4 h-full bg-white rounded-lg shadow-lg max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-center">Daily Puzzle</h1>
    @if ($error)
        <div class="text-center mb-4 text-red-500">{{ $error }}</div>
    @endif

    <!-- Grid and Game -->
    <div
        x-data="flowGame({
            gridSize: @js($puzzle['grid_size']),
            cells: @js($puzzle['cells']),
            connections: @js($puzzle['connections']),
            puzzleId: @js($puzzle['id'])
        })"
        x-init="init()"
        class="relative w-[500px] h-[500px] mx-auto border-4 border-gray-800"
    >
        <!-- Grid -->
        <div
            class="absolute inset-0 grid"
            :class="`grid-cols-${gridSize} grid-rows-${gridSize}`"
        >
            <template x-for="row in gridSize" :key="row">
                <template x-for="col in gridSize" :key="col">
                    <div
                        class="border border-gray-400 relative"
                        @mousedown="startPath(row - 1, col - 1)"
                        @mouseenter="extendPath(row - 1, col - 1)"
                        @mouseup="endPath(row - 1, col - 1)"
                    >
                        <template x-for="cell in endpointMap[`${row-1},${col-1}`] || []">
                            <div
                                class="w-8 h-8 rounded-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                                :style="`background-color: ${cell.color}`"
                            ></div>
                        </template>
                    </div>
                </template>
            </template>
        </div>

        <!-- Path drawing layer -->
        <svg class="absolute inset-0 pointer-events-none z-10">
            <!-- Completed paths -->
            <template x-for="(path, index) in (paths || [])" :key="`completed-${index}`">
                <polyline
                    x-show="path && path.cells && path.cells.length > 1"
                    :points="pathToPoints(path)"
                    :stroke="path.color"
                    fill="none"
                    stroke-width="20"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </template>
            <!-- Temporary path while drawing -->
            <polyline
                x-show="currentPath && currentPath.cells && currentPath.cells.length > 0"
                :points="currentPath ? pathToPoints(currentPath) : ''"
                :stroke="currentPath ? currentPath.color : 'transparent'"
                fill="none"
                stroke-width="20"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </div>

    <!-- Controls -->
    <div class="mt-4 text-center space-x-2">
        <button
            :disabled="!isComplete"
            @click="submitSolution"
            class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
        >Submit</button>
        <button
            @click="reset"
            class="bg-red-500 text-white px-4 py-2 rounded"
        >Reset</button>
    </div>
</div>

@push('scripts')
<script>
function flowGame({ gridSize, cells, connections, puzzleId }) {
    return {
        gridSize,
        cells,
        connections,
        puzzleId,
        paths: [],
        currentPath: null,
        cellSize: 500 / gridSize,
        endpointMap: {},
        isComplete: false,

        init() {
            console.log('Initializing flowGame with:', { gridSize, cells, connections, puzzleId });
            // Map endpoints to grid positions
            for (const cell of this.cells) {
                const key = `${cell.row},${cell.col}`;
                if (!this.endpointMap[key]) this.endpointMap[key] = [];
                this.endpointMap[key].push(cell);
            }
            this.paths = []; // Ensure paths is initialized
            this.checkCompletion();
        },

        startPath(row, col) {
            const key = `${row},${col}`;
            const cell = this.endpointMap[key]?.[0];
            if (!cell) return;

            console.log('Starting path at:', row, col, 'Color:', cell.color);
            this.currentPath = {
                color: cell.color,
                cells: [{ row, col }]
            };
        },

        extendPath(row, col) {
            if (!this.currentPath) return;

            const last = this.currentPath.cells.at(-1);
            if (Math.abs(last.row - row) + Math.abs(last.col - col) !== 1) return; // Must be adjacent

            // Prevent overlapping with existing paths of different colors
            const existingPath = this.paths.find(p => p.color !== this.currentPath.color && p.cells.some(c => c.row === row && c.col === col));
            if (existingPath) return;

            this.currentPath.cells.push({ row, col });
            console.log('Extended path to:', row, col);
        },

        endPath(row, col) {
            if (!this.currentPath) return;

            // Check if the end is a valid endpoint of the same color
            const key = `${row},${col}`;
            const endpoint = this.endpointMap[key]?.[0];
            if (endpoint && endpoint.color === this.currentPath.color) {
                this.currentPath.cells.push({ row, col });
                // Remove any existing path of the same color
                this.paths = this.paths.filter(p => p.color !== this.currentPath.color);
                if (this.currentPath.cells.length > 1) {
                    this.paths.push({ ...this.currentPath }); // Ensure a new object is pushed
                    console.log('Completed path:', this.currentPath);
                }
            } else {
                console.log('Invalid path, discarding');
            }

            this.currentPath = null;
            this.checkCompletion();
        },

        pathToPoints(path) {
            if (!path || !path.cells) return '';
            return path.cells.map(c => {
                const x = c.col * this.cellSize + this.cellSize / 2;
                const y = c.row * this.cellSize + this.cellSize / 2;
                return `${x},${y}`;
            }).join(' ');
        },

        checkCompletion() {
            this.isComplete = this.connections.every(conn => {
                const path = this.paths.find(p => p.color === conn.color);
                if (!path) return false;
                const startCell = this.cells.find(c => c.id === conn.start_cell_id);
                const endCell = this.cells.find(c => c.id === conn.end_cell_id);
                const pathStart = path.cells[0];
                const pathEnd = path.cells[path.cells.length - 1];
                return startCell && endCell &&
                       pathStart.row === startCell.row && pathStart.col === startCell.col &&
                       pathEnd.row === endCell.row && pathEnd.col === endCell.col;
            });
            console.log('Is complete:', this.isComplete);
        },

        reset() {
            this.paths = [];
            this.currentPath = null;
            this.checkCompletion();
            console.log('Reset paths');
        },

        submitSolution() {
            if (!this.isComplete) return;

            const moveList = this.paths.map(path => ({
                color: path.color,
                path: path.cells.map(c => [c.col, c.row])
            }));

            console.log('Submitting solution:', { puzzle_id: this.puzzleId, move_list: moveList });
            fetch('/api/attempts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    puzzle_id: this.puzzleId,
                    move_list: moveList,
                    time_ms: 0
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.reload();
            })
            .catch(error => {
                alert('Error submitting solution: ' + error.message);
            });
        }
    };
}
</script>
@endpush