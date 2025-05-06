<div>
    <h2 class="text-2xl font-bold mb-4">Today's Puzzle</h2>

    <div wire:ignore id="puzzle-container" class="grid grid-cols-5 gap-1"></div>

    <button wire:click="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white">Submit</button>

    @if (session()->has('message'))
        <div class="mt-2 text-green-600">{{ session('message') }}</div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const res = await fetch('/api/puzzle/today');
            const puzzle = await res.json();

            const grid = puzzle.data;
            const container = document.getElementById('puzzle-container');
            container.innerHTML = '';

            grid.forEach((row, y) => {
                row.forEach((cell, x) => {
                    const div = document.createElement('div');
                    div.classList.add('w-10', 'h-10', 'border', 'flex', 'items-center', 'justify-center', 'bg-gray-100');
                    div.textContent = cell;
                    container.appendChild(div);
                });
            });

            // You could store puzzle.seed or puzzle.solution in JS/localStorage if needed
        });
    </script>
</div>
