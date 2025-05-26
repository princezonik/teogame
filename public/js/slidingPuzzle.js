document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const puzzleContainer = document.getElementById('puzzle-grid');
    const difficultySelector = document.getElementById('difficulty');
    const startButton = document.getElementById('start-game');
    const popup = document.getElementById('solved-popup');
    const closePopupBtn = document.getElementById('close-popup');
    const moveCounter = document.getElementById('move-counter');
    const timeCounter = document.getElementById('time-counter');
    const bestMovesCounter = document.getElementById('best-moves-counter');

    // Game State
    let gridSize = 3;
    let moveCount = 0;
    let startTime;
    let timerInterval;
    let currentTiles = [];
    let isSolving = false;
    let isGameStarted = false;

    // Initialize the game
    function initGame() {
        generatePuzzle(gridSize);
        setupEventListeners();
        loadLocalBestStats();
        checkPendingScores();
    }

    // Generate a new puzzle
    function generatePuzzle(size) {
        if (isSolving) return;

        gridSize = size;
        const total = size * size;
        currentTiles = Array.from({ length: total }, (_, i) => i);

        let attempts = 0;
        const MAX_ATTEMPTS = 1000;

        do {
            shuffle(currentTiles);
            attempts++;
        } while ((!isSolvable(currentTiles, size) || isSolved(currentTiles)) && attempts < MAX_ATTEMPTS);

        if (attempts >= MAX_ATTEMPTS) {
            showTemporaryMessage("Failed to generate puzzle. Reloading...");
            setTimeout(() => location.reload(), 1500);
            return;
        }

        renderTiles();
        resetGameStats();
    }

    // Shuffle array
    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    // Check if puzzle is solvable
    function isSolvable(tiles, size) {
        let invCount = 0;
        for (let i = 0; i < tiles.length - 1; i++) {
            for (let j = i + 1; j < tiles.length; j++) {
                if (tiles[i] && tiles[j] && tiles[i] > tiles[j]) {
                    invCount++;
                }
            }
        }

        if (size % 2 === 1) {
            return invCount % 2 === 0;
        } else {
            const rowFromBottom = size - Math.floor(tiles.indexOf(0) / size);
            return (invCount + rowFromBottom) % 2 === 0;
        }
    }

    // Check if puzzle is solved
    function isSolved(tiles) {
        for (let i = 0; i < tiles.length - 1; i++) {
            if (tiles[i] !== i + 1) return false;
        }
        return tiles[tiles.length - 1] === 0;
    }

    // Render tiles
    function renderTiles() {
        puzzleContainer.innerHTML = '';
        puzzleContainer.style.gridTemplateColumns = `repeat(${gridSize}, 1fr)`;

        currentTiles.forEach((value, index) => {
            const tile = document.createElement('div');
            tile.className = `tile ${value === 0 ? 'empty' : 'clickable'}`;
            tile.dataset.index = index;
            tile.dataset.value = value;

            if (value !== 0) {
                tile.textContent = value;
                tile.addEventListener('click', () => handleTileClick(index));
            }

            puzzleContainer.appendChild(tile);
        });
    }

    // Handle tile click
    function handleTileClick(clickedIndex) {
        if (isSolving || !isGameStarted) return;

        const emptyIndex = currentTiles.indexOf(0);

        if (isAdjacent(clickedIndex, emptyIndex)) {
            moveCount++;
            moveCounter.textContent = moveCount;

            [currentTiles[clickedIndex], currentTiles[emptyIndex]] =
                [currentTiles[emptyIndex], currentTiles[clickedIndex]];

            renderTiles();

            if (isSolved(currentTiles)) {
                handlePuzzleSolved();
            }
        }
    }

    // Check if tiles are adjacent
    function isAdjacent(a, b) {
        const rowA = Math.floor(a / gridSize), colA = a % gridSize;
        const rowB = Math.floor(b / gridSize), colB = b % gridSize;
        return Math.abs(rowA - rowB) + Math.abs(colA - colB) === 1;
    }

    // Reset game stats
    function resetGameStats() {
        moveCount = 0;
        moveCounter.textContent = '0';
        resetTimer();
        isSolving = false;
        isGameStarted = false;
        startButton.textContent = 'Start Game';
    }

    // Timer functions
    function startTimer() {
        startTime = Date.now();
        timerInterval = setInterval(updateTimer, 1000);
    }

    function updateTimer() {
        const elapsed = Math.floor((Date.now() - startTime) / 1000);
        timeCounter.textContent = formatTime(elapsed);
    }

    function stopTimer() {
        clearInterval(timerInterval);
    }

    function resetTimer() {
        stopTimer();
        timeCounter.textContent = "0:00";
    }

    // Format time
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    // Handle puzzle completion
    async function handlePuzzleSolved() {
        isSolving = true;
        stopTimer();
        popup.classList.remove('hidden');
        const elapsed = Math.floor((Date.now() - startTime) / 1000);

        // Save stats
        saveStats(elapsed);

        // Emit to Livewire for authenticated users
        if (window.isAuthenticated) {
            const scoreData = {
                moves: moveCount,
                time: elapsed,
                difficulty: gridSize,
                game_id: window.gameId,
                timestamp: new Date().toISOString()
            };

            console.log('Emitting puzzleSolved event', scoreData);
            const success = await safeLivewireEmit('puzzleSolved', scoreData);

            if (!success) {
                showTemporaryMessage('Score will be saved when connection improves');
            }
        }
    }

    // Save stats to localStorage for non-authenticated users
    function saveStats(elapsed) {
        if (window.isAuthenticated) return;

        const statsKey = `puzzle_stats_${gridSize}x${gridSize}`;
        let stats = JSON.parse(localStorage.getItem(statsKey) || '{}');

        stats.bestMoves = Math.min(stats.bestMoves || Infinity, moveCount);
        stats.bestTime = Math.min(stats.bestTime || Infinity, elapsed);
        stats.lastMoves = moveCount;
        stats.lastTime = elapsed;
        stats.date = new Date().toISOString();

        localStorage.setItem(statsKey, JSON.stringify(stats));
        updateBestMovesDisplay();
    }

    // Load local best stats
    function loadLocalBestStats() {
        if (window.isAuthenticated) return;

        const statsKey = `puzzle_stats_${gridSize}x${gridSize}`;
        const stats = JSON.parse(localStorage.getItem(statsKey) || '{}');
        bestMovesCounter.textContent = stats.bestMoves || 'N/A';
    }

    // Update best moves display
    function updateBestMovesDisplay() {
        if (window.isAuthenticated) return;

        const statsKey = `puzzle_stats_${gridSize}x${gridSize}`;
        const stats = JSON.parse(localStorage.getItem(statsKey) || '{}');
        bestMovesCounter.textContent = stats.bestMoves || 'N/A';
    }

    // Safe Livewire emission
    async function safeLivewireEmit(eventName, data, retries = 5, delay = 1000) {
        console.log('Attempting to emit Livewire event', { eventName, data });
        try {
            let attempt = 0;
            while (attempt <= retries) {
                if (window.Livewire && typeof window.Livewire.find === 'function') {
                    const component = window.Livewire.getByName('sliding-puzzle')[0];
                    if (component) {
                        window.Livewire.dispatch(eventName, data);
                        console.log('Livewire event dispatched', { eventName, data });
                        return true;
                    }
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

    // Check pending scores
    function checkPendingScores() {
        if (!window.isAuthenticated) return;

        const pendingEvents = JSON.parse(localStorage.getItem('pendingLivewireEvents') || '[]');
        if (pendingEvents.length > 0 && window.Livewire && typeof window.Livewire.dispatch === 'function') {
            console.log('Processing pending events', pendingEvents);
            pendingEvents.forEach(event => {
                try {
                    window.Livewire.dispatch(event.eventName, event.data);
                    console.log('Processed pending event', event);
                } catch (e) {
                    console.error('Failed to process pending event:', e);
                }
            });
            localStorage.removeItem('pendingLivewireEvents');
        }
    }

    // Show temporary message
    function showTemporaryMessage(message, duration = 3000) {
        const messageEl = document.createElement('div');
        messageEl.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        messageEl.textContent = message;
        document.body.appendChild(messageEl);

        setTimeout(() => messageEl.remove(), duration);
    }

    // Event listeners
    function setupEventListeners() {
        difficultySelector.addEventListener('change', () => {
            generatePuzzle(parseInt(difficultySelector.value));
            loadLocalBestStats();
        });

        startButton.addEventListener('click', () => {
            if (!isGameStarted) {
                isGameStarted = true;
                startButton.textContent = 'Restart Game';
                startTimer();
            } else {
                generatePuzzle(gridSize);
                loadLocalBestStats();
            }
        });

        closePopupBtn.addEventListener('click', () => {
            popup.classList.add('hidden');
            generatePuzzle(gridSize);
            loadLocalBestStats();
        });

        if (typeof Livewire === 'undefined') {
            document.addEventListener('livewire:initialized', () => {
                console.log('Livewire initialized, checking pending scores');
                checkPendingScores();
            });
        } else {
            checkPendingScores();
        }
    }

    // Initialize
    initGame();
});