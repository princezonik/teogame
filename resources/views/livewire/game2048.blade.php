<div class="flex flex-col items-center justify-center min-h-screen bg-[#faf8ef]">
    <div class="text-center mb-4">
        <div class="flex justify-center gap-4">
            <div class="bg-[#bbada0] text-white px-4 py-2 rounded shadow-lg">
                <div class="text-xs uppercase">Score</div>
                <div id="score" class="text-xl font-bold">0</div>
            </div>
            <div class="bg-[#bbada0] text-white px-4 py-2 rounded shadow-lg">
                <div class="text-xs uppercase">Best</div>
                <div id="best" class="text-xl font-bold">0</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-2 bg-[#bbada0] p-4 rounded-lg shadow-xl" id="game-board">
        @for($i = 0; $i < 16; $i++)
            <div class="tile flex items-center justify-center text-2xl font-bold h-20 w-20 text-[#756452] transition-all duration-200 ease-out transform rounded-lg shadow-md hover:shadow-xl" data-index="{{ $i }}"></div>
        @endfor
    </div>

    <div class="mt-4 flex gap-2">
        <button onclick="newGame()" class="bg-[#8f7a66] text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-2xl">New Game</button>
        <button onclick="undoMove()" class="bg-[#8f7a66] text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-2xl">Undo</button>
        <button onclick="replayGame()" class="bg-[#8f7a66] text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-2xl">Replay</button>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const style = document.createElement('style');
            style.innerHTML = `
                .tile {
                    animation: pop 0.2s ease;
                    color: #756452;
                }
                @keyframes pop {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.1); }
                    100% { transform: scale(1); }
                }

                .bg-0    { background-color: #cdc1b4; }
                .bg-2    { background-color: #eee4da; }
                .bg-4    { background-color: #ebd8b6; }
                .bg-8    { background-color: #eac69b; }
                .bg-16   { background-color: #e9b480; }
                .bg-32   { background-color: #e8a265; }
                .bg-64   { background-color: #f2af74; }
                .bg-128  { background-color: #f3b67f; }
                .bg-256  { background-color: #f4bd8a; }
                .bg-512  { background-color: #f5c495; }
                .bg-1024 { background-color: #f6cba0; }
                .bg-2048 { background-color: #f7d2ab; }
            `;
            document.head.appendChild(style);
        });
    </script>
    <script src="{{ asset('js/2048.js') }}"></script>
@endpush
