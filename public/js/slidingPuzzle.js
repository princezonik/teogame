document.addEventListener('DOMContentLoaded', () => {
    //  DOM Elements
    const puzzleGrid = document.getElementById('puzzle-grid');
    const difficultySelect = document.getElementById('difficulty');
    const startBtn = document.getElementById('start-game');
    const popup = document.getElementById('solved-popup');
    const closePopup = document.getElementById('close-popup');
    const moveCounter = document.getElementById('move-counter');
    const timeCounter = document.getElementById('time-counter');
    const bestMovesCounter = document.getElementById('best-moves-counter');

    //  Game State 
    let gridSize = 3;
    let tiles = [];
    let moveCount = 0;
    let startTime = null;
    let timer = null;
    let gameActive = false;
    let puzzleSolved = false;

    //  Initialization
    function init() {
        setupEventListeners();
        generatePuzzle(gridSize);
        loadBestStats();
    }

    //  Puzzle Generation 
    function generatePuzzle(size) {
        gridSize = size;
        const total = size * size;
        tiles = Array.from({ length: total }, (_, i) => i);

        let attempts = 0;
        const MAX_ATTEMPTS = 1000;
        do {
            shuffle(tiles);
            attempts++;
        } while ((!isSolvable(tiles, size) || isPuzzleSolved()) && attempts < MAX_ATTEMPTS);

        renderPuzzle();
    }

    function shuffle(arr) {
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
    }

    function isSolvable(arr, size) {
        let inversions = 0;
        for (let i = 0; i < arr.length; i++) {
            for (let j = i + 1; j < arr.length; j++) {
                if (arr[i] && arr[j] && arr[i] > arr[j]) inversions++;
            }
        }
        if (size % 2 === 1) return inversions % 2 === 0;
        const emptyRow = size - Math.floor(arr.indexOf(0) / size);
        return (inversions + emptyRow) % 2 === 0;
    }

    function isPuzzleSolved() {
        for (let i = 0; i < tiles.length - 1; i++) {
            if (tiles[i] !== i + 1) return false;
        }
        return tiles[tiles.length - 1] === 0;
    }

    //  Rendering 
    function renderPuzzle() {
        puzzleGrid.innerHTML = '';
        puzzleGrid.style.gridTemplateColumns = `repeat(${gridSize}, 1fr)`;

        tiles.forEach((val, idx) => {
            const tile = document.createElement('div');
            tile.className = val === 0 ? 'tile empty' : 'tile clickable';
            tile.dataset.index = idx;
            tile.textContent = val || '';
            if (val !== 0) {
                tile.addEventListener('click', () => handleTileClick(idx));
            }
            puzzleGrid.appendChild(tile);
        });
    }

    // User Interaction
    function handleTileClick(index) {
        if (!gameActive || puzzleSolved) return;

        const emptyIndex = tiles.indexOf(0);
        if (!isAdjacent(index, emptyIndex)) return;

        [tiles[index], tiles[emptyIndex]] = [tiles[emptyIndex], tiles[index]];
        moveCount++;
        updateMoveDisplay();
        renderPuzzle();

        if (isPuzzleSolved()) handleWin();
    }

    function isAdjacent(a, b) {
        const [ra, ca] = [Math.floor(a / gridSize), a % gridSize];
        const [rb, cb] = [Math.floor(b / gridSize), b % gridSize];
        return Math.abs(ra - rb) + Math.abs(ca - cb) === 1;
    }

    // Timer & Moves
    function startGame() {
        moveCount = 0;
        puzzleSolved = false;
        gameActive = true;
        updateMoveDisplay();
        startTime = Date.now();
        updateTimer();
        timer = setInterval(updateTimer, 1000);
        startBtn.textContent = 'Restart Game';
    }

    function updateMoveDisplay() {
        moveCounter.textContent = moveCount;
    }

    function updateTimer() {
        const seconds = Math.floor((Date.now() - startTime) / 1000);
        timeCounter.textContent = formatTime(seconds);
    }

    function stopTimer() {
        clearInterval(timer);
        timer = null;
    }

    function formatTime(sec) {
        const m = Math.floor(sec / 60);
        const s = sec % 60;
        return `${m}:${s.toString().padStart(2, '0')}`;
    }

    //  Win Handling 
    async function handleWin() {
        stopTimer();
        puzzleSolved = true;
        gameActive = false;
        const timeTaken = Math.floor((Date.now() - startTime) / 1000);
        updateBestStats(timeTaken);

        popup.querySelector('.moves').textContent = moveCount;
        popup.querySelector('.time').textContent = formatTime(timeTaken);
        popup.querySelector('.best-moves').textContent = localStorage.getItem(`best_moves_${gridSize}`) || 'N/A';
        popup.classList.remove('hidden');

        // Emit to Livewire for authenticated users
         
        setTimeout(() => {
            if (window.isAuthenticated) {
                const scoreData = {
                    moves: moveCount,
                    time: timeTaken,
                    difficulty: gridSize,
                    game_id: window.gameId,
                    timestamp: new Date().toISOString()
                };

                console.log('Preparing to emit puzzleSolved', scoreData);
                safeLivewireEmit('puzzleSolved', scoreData).then(success => {
                    if (!success) {
                        showTemporaryMessage('Score will be saved when connection improves');
                    }
                });
            }
        }, 0);
    }

    // Safe Livewire emission
    async function safeLivewireEmit(eventName, data, retries = 5, delay = 1000) {
        console.log('Attempting to emit Livewire event', { eventName, data });
        try {
            let attempt = 0;
            while (attempt <= retries) {
                if (window.slidingPuzzleWire && typeof window.slidingPuzzleWire.$dispatch === 'function') {
                    window.slidingPuzzleWire.call(eventName, data);
                    console.log('Livewire event dispatched via $dispatch', { eventName, data });
                    return true;
                }
                    
                console.log(`Retry ${attempt + 1} for Livewire event`, { eventName, data });
                await new Promise(resolve => setTimeout(resolve, delay));
                attempt++;
            }

            console.warn('Livewire or SlidingPuzzle component unavailable, storing event', { eventName, data });
            const pendingEvents = JSON.parse(localStorage.getItem('pendingLivewireEvents') || '[]');
            pendingEvents.push({ eventName, data });
            localStorage.setItem('pendingLivewireEvents', JSON.stringify(pendingEvents));
            return false;
        } catch (error) {
            console.error('Error emitting Livewire event:', error);
            return false;
        }
    }

    //  Stats Management ===
    function updateBestStats(timeTaken) {
        const key = `best_moves_${gridSize}`;
        const bestMoves = parseInt(localStorage.getItem(key)) || Infinity;
        if (moveCount < bestMoves) localStorage.setItem(key, moveCount);
        bestMovesCounter.textContent = Math.min(moveCount, bestMoves);
    }

    function loadBestStats() {
        const best = localStorage.getItem(`best_moves_${gridSize}`) || 'N/A';
        bestMovesCounter.textContent = best;
    }

    //  Event Listeners 
    function setupEventListeners() {
        difficultySelect.addEventListener('change', () => {
            gridSize = parseInt(difficultySelect.value);
            generatePuzzle(gridSize);
            gameActive = false;
            startBtn.textContent = 'Start Game';
        });

        startBtn.addEventListener('click', () => {
            generatePuzzle(gridSize);
            startGame();
        });

        closePopup.addEventListener('click', () => {
            popup.classList.add('hidden');
        });
    }

    //  Run Game 
    init();
});
