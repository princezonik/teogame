document.addEventListener('DOMContentLoaded', () => {
    const puzzleContainer = document.getElementById('puzzle-grid');
    const difficultySelector = document.getElementById('difficulty');
    const popup = document.getElementById('solved-popup');
    const closePopupBtn = document.getElementById('close-popup');
    const moveCounter = document.getElementById('move-counter');
    const timeCounter = document.getElementById('time-counter');

    let gridSize = 3;
    let moveCount = 0;
    let startTime;
    let timerInterval;

    function generatePuzzle(size) {
        gridSize = size;
        const total = size * size;
        let tiles = Array.from({ length: total }, (_, i) => i);

        let attempts = 0;
        const MAX_ATTEMPTS = 1000;

        do {
            shuffle(tiles);
            attempts++;
        } while ((!isSolvable(tiles, size) || isSolved(tiles)) && attempts < MAX_ATTEMPTS);

        if (attempts >= MAX_ATTEMPTS) {
            alert("Failed to generate a solvable puzzle. Try reloading the page.");
            return;
        }

        renderTiles(tiles);
        moveCount = 0;
        moveCounter.textContent = '0';
        resetTimer();
        startTimer();
    }

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

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

    function isSolved(tiles) {
        for (let i = 0; i < tiles.length - 1; i++) {
            if (tiles[i] !== i + 1) return false;
        }
        return tiles[tiles.length - 1] === 0;
    }

    function renderTiles(tiles) {
        puzzleContainer.innerHTML = '';
        puzzleContainer.style.gridTemplateColumns = `repeat(${gridSize}, 1fr)`;

        tiles.forEach((value, index) => {
            const tile = document.createElement('div');
            tile.classList.add('tile');
            tile.dataset.index = index;
            tile.dataset.value = value;

            if (value === 0) {
                tile.classList.add('empty');
            } else {
                tile.textContent = value;
            }

            tile.addEventListener('click', () => tryMove(index));
            puzzleContainer.appendChild(tile);
        });
    }

    function tryMove(clickedIndex) {
        const tiles = Array.from(puzzleContainer.children);
        const emptyIndex = tiles.findIndex(tile => tile.classList.contains('empty'));

        if (isAdjacent(clickedIndex, emptyIndex)) {
            moveCount++;
            moveCounter.textContent = moveCount;

            swapTiles(clickedIndex, emptyIndex);
            updateIndices();

            const currentValues = Array.from(puzzleContainer.children).map(t => parseInt(t.dataset.value));
            if (isSolved(currentValues)) {
                stopTimer();
                popup.classList.remove('hidden');
                saveStats();
            }
        }
    }

    function isAdjacent(a, b) {
        const rowA = Math.floor(a / gridSize), colA = a % gridSize;
        const rowB = Math.floor(b / gridSize), colB = b % gridSize;
        return Math.abs(rowA - rowB) + Math.abs(colA - colB) === 1;
    }

    function swapTiles(i, j) {
        const tiles = puzzleContainer.children;
        const tempHTML = tiles[i].outerHTML;
        tiles[i].outerHTML = tiles[j].outerHTML;
        tiles[j].outerHTML = tempHTML;
    }

    function updateIndices() {
        Array.from(puzzleContainer.children).forEach((tile, index) => {
            tile.dataset.index = index;
            tile.addEventListener('click', () => tryMove(index));
        });
    }

    difficultySelector.addEventListener('change', () => {
        const size = parseInt(difficultySelector.value);
        generatePuzzle(size);
    });

    closePopupBtn.addEventListener('click', () => {
        popup.classList.add('hidden');
        generatePuzzle(gridSize);
    });

    function startTimer() {
        startTime = Date.now();
        timerInterval = setInterval(() => {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            timeCounter.textContent = formatTime(elapsed);
        }, 1000);
    }

    function stopTimer() {
        clearInterval(timerInterval);
    }

    function resetTimer() {
        clearInterval(timerInterval);
        timeCounter.textContent = "0:00";
    }

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    function saveStats() {
        const elapsed = Math.floor((Date.now() - startTime) / 1000);
        const stats = {
            difficulty: gridSize,
            moves: moveCount,
            time: elapsed,
            date: new Date().toISOString()
        };
        localStorage.setItem(`slidingPuzzle_last_${gridSize}x${gridSize}`, JSON.stringify(stats));
    }

    // Start initial game
    generatePuzzle(gridSize);
});
