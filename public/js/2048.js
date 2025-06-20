let grid = Array(16).fill(0);
let score = 0;
let history = []; // For undo
let moveHistory = []; // For replay

document.addEventListener("DOMContentLoaded", () => {
    loadGame();
    document.addEventListener("keydown", handleKey);
    render();
});

function newGame() {
    grid = Array(16).fill(0);
    addTile();
    addTile();
    score = 0;
    history = [];
    moveHistory = [];
    saveGame();
    render();
}

function handleKey(e) {
    const key = e.key;
    if (["ArrowLeft", "ArrowRight", "ArrowUp", "ArrowDown"].includes(key)) {
        e.preventDefault();
        let moved = move(key);
        if (moved) {
            addTile();
            saveGame();
            render();
        }
    }
}

function move(direction) {
    let moved = false;
    let original = [...grid];

    history.push({ grid: [...grid], score });

    for (let i = 0; i < 4; i++) {
        let line = getLine(i, direction);
        let mergedLine = mergeLine(line);
        setLine(i, mergedLine, direction);
    }

    moved = !arraysEqual(grid, original);
    if (moved) {
        moveHistory.push({ grid: [...grid], score, direction });
    } else {
        history.pop();
    }
    return moved;
}

function undoMove() {
    if (history.length > 0) {
        const last = history.pop();
        grid = [...last.grid];
        score = last.score;
        saveGame();
        render();
    } else {
        alert("No moves to undo!");
    }
}

function replayGame(index = 0) {
    if (index >= moveHistory.length) return;
    const state = moveHistory[index];
    grid = [...state.grid];
    score = state.score;
    render();
    setTimeout(() => replayGame(index + 1), 300);
}

function getLine(index, direction) {
    let line = [];
    for (let i = 0; i < 4; i++) {
        switch (direction) {
            case "ArrowLeft": line.push(grid[index * 4 + i]); break;
            case "ArrowRight": line.push(grid[index * 4 + (3 - i)]); break;
            case "ArrowUp": line.push(grid[i * 4 + index]); break;
            case "ArrowDown": line.push(grid[(3 - i) * 4 + index]); break;
        }
    }
    return line;
}

function setLine(index, line, direction) {
    for (let i = 0; i < 4; i++) {
        let value = line[i];
        switch (direction) {
            case "ArrowLeft": grid[index * 4 + i] = value; break;
            case "ArrowRight": grid[index * 4 + (3 - i)] = value; break;
            case "ArrowUp": grid[i * 4 + index] = value; break;
            case "ArrowDown": grid[(3 - i) * 4 + index] = value; break;
        }
    }
}

function mergeLine(line) {
    let newLine = line.filter(v => v !== 0);
    for (let i = 0; i < newLine.length - 1; i++) {
        if (newLine[i] === newLine[i + 1]) {
            newLine[i] *= 2;
            score += newLine[i];
            newLine[i + 1] = 0;
        }
    }
    return newLine.filter(v => v !== 0).concat(Array(4 - newLine.filter(v => v !== 0).length).fill(0));
}

function addTile() {
    const empty = grid.map((v, i) => v === 0 ? i : null).filter(v => v !== null);
    if (empty.length === 0) return;
    const index = empty[Math.floor(Math.random() * empty.length)];
    grid[index] = Math.random() < 0.9 ? 2 : 4;
}

async function render() {
    document.querySelectorAll('.tile').forEach((tile, index) => {
        tile.textContent = grid[index] === 0 ? '' : grid[index];
        tile.className = 'tile flex items-center justify-center text-2xl font-bold h-20 w-20 transition-all tile-move ' +
            getTileColor(grid[index]);
    });
    document.getElementById('score').textContent = score;
    const best = Math.max(score, parseInt(localStorage.getItem("best") || "0"));
    document.getElementById('best').textContent = best;
    localStorage.setItem("best", best);

    if (isGameOver()) {
        setTimeout(async () => {
            alert("Game Over!");

             // Emit to Livewire for authenticated users
            if (window.isAuthenticated) {
                const moves = moveHistory.length; // this is available
                const timestamp = new Date().toISOString();
                const game_id = document.getElementById('game-id').value;
                const bestMoves = moves; // set to same for now
                const scoreData = { moves, bestMoves, game_id, timestamp };
                
                console.log('Emitting puzzleSolved event', scoreData);
                const success = await safeLivewireEmit('puzzleSolved', scoreData);
                
                if (!success) {
                    showTemporaryMessage('Score will be saved when connection improves');
                }
            }
            
        }, 200);
    }
}

async function safeLivewireEmit(eventName, data, retries = 5, delay = 500) {
    console.log('Attempting to dispatch Livewire event', { eventName, data });

    try {
        let attempt = 0;
        while (attempt <= retries) {
            if (typeof Livewire !== 'undefined' && typeof Livewire.dispatch === 'function') {
                Livewire.dispatch(eventName, data);
                console.log('Livewire event dispatched via Livewire.dispatch', { eventName, data });
                return true;
            }

            console.log(`Retry ${attempt + 1} for Livewire.dispatch`, { eventName, data });
            await new Promise(resolve => setTimeout(resolve, delay));
            attempt++;
        }

        console.warn('Livewire.dispatch not available, storing event locally', { eventName, data });
        const pendingEvents = JSON.parse(localStorage.getItem('pendingLivewireEvents') || '[]');
        pendingEvents.push({ eventName, data });
        localStorage.setItem('pendingLivewireEvents', JSON.stringify(pendingEvents));
        return false;

    } catch (error) {
        console.error('Error dispatching Livewire event:', error);
        return false;
    }
}


function getTileColor(value) {
    const validValues = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048];
    return validValues.includes(value) ? `bg-${value}` : 'bg-[#cdc1b4]';
}

function saveGame() {
    localStorage.setItem("grid", JSON.stringify(grid));
    localStorage.setItem("score", score);
    localStorage.setItem("moveHistory", JSON.stringify(moveHistory));
    if (!window.isAuthenticated) {
        const gameId = document.getElementById('game-id').value;
        localStorage.setItem(`game_${gameId}_score`, JSON.stringify({ score, moves: moveHistory.length }));
    }
}

function loadGame() {
    const savedGrid = JSON.parse(localStorage.getItem("grid"));
    const savedScore = parseInt(localStorage.getItem("score") || "0");
    moveHistory = JSON.parse(localStorage.getItem("moveHistory")) || [];

    if (savedGrid && savedGrid.length === 16) {
        grid = savedGrid;
        score = savedScore;
    } else {
        newGame();
    }
}

function arraysEqual(a, b) {
    return JSON.stringify(a) === JSON.stringify(b);
}

function isGameOver() {
    for (let i = 0; i < 16; i++) {
        if (grid[i] === 0) return false;
        let x = i % 4;
        let y = Math.floor(i / 4);
        if (x < 3 && grid[i] === grid[i + 1]) return false;
        if (y < 3 && grid[i] === grid[i + 4]) return false;
    }
    
   
    return true;
}



function showTemporaryMessage(message, duration = 3000) {
    console.log('Showing temporary message:', message);
    const messageEl = document.createElement('div');
    messageEl.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50';
    messageEl.textContent = message;
    document.body.appendChild(messageEl);

    setTimeout(() => messageEl.remove(), duration);
}