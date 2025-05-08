document.addEventListener('DOMContentLoaded', () => {
    const puzzleContainer = document.getElementById('puzzle-grid');
    const difficultySelector = document.getElementById('difficulty');
    const popup = document.getElementById('solved-popup');
    const closePopupBtn = document.getElementById('close-popup');

    let gridSize = 3;

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
            swapTiles(clickedIndex, emptyIndex);
            updateIndices();

            const currentValues = Array.from(puzzleContainer.children).map(t => parseInt(t.dataset.value));
            if (isSolved(currentValues)) {
                popup.classList.remove('hidden');
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

    // Initial render
    generatePuzzle(gridSize);
});
