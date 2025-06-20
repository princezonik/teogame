// For getting data
function getLocalStorage(key, defaultValue = null) {
    try {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : defaultValue;
    } catch (error) {
        console.error(`Error parsing localStorage key "${key}":`, error);
        localStorage.removeItem(key); // Remove corrupted data
        return defaultValue;
    }
}

// For setting data
function setLocalStorage(key, value) {
    try {
        localStorage.setItem(key, JSON.stringify(value));
    } catch (error) {
        console.error(`Error saving to localStorage key "${key}":`, error);
        // Handle storage full errors if needed
    }
}

// Initialize storage when Alpine starts
document.addEventListener('alpine:init', () => {
  if (getLocalStorage('pendingScores') === null) {
    setLocalStorage('pendingScores', []);
  }
  if (getLocalStorage('guestScores') === null) {
    setLocalStorage('guestScores', {});
  }
 
});

function puzzleBoard(data) {
    const MIN_COLOR_PAIRS = 4;

    // Validate and initialize connections
    if (Object.keys(data.connections || {}).length < MIN_COLOR_PAIRS) {
        console.warn(`Puzzle must have at least ${MIN_COLOR_PAIRS} color pairs`);
        data.connections = data.connections || {};
        const defaultColors = ['red', 'blue', 'green', 'yellow', 'orange', 'purple'];
        defaultColors.forEach((color, i) => {
            if (!data.connections[color]) {
                data.connections[color] = {
                    start: [0, i],
                    end: [data.gridSize - 1, i],
                };
            }
        });
    }

    return {
        gridSize: data.gridSize || 5,
        cells: data.cells || {},
        connections: data.connections || {},
        userPaths: data.userPaths || {},
        isCompleted: data.isCompleted || false,
        moves: data.moves || 0,
        bestMoves: data.bestMoves || null,
        score: null,
        drawing: null,
        lastPoint: null,
        tempPath: null,
        newBest: false,
        _hasDispatchedCompletion: false,
        isSolving: false,
     

        async init() {
            this.gameId = gameId;
            this.originalCells = JSON.parse(JSON.stringify(this.cells));
            this.originalConnections = JSON.parse(JSON.stringify(this.connections));
            this.loadBestMoves(gameId);
            this.setupEventListeners();
            this.renderAll();

            this.$watch('isCompleted', async (newVal) => {
                if (newVal && !this.isSolving) {
                    await this.handlePuzzleCompletion();
                }
            });  
        },

        async handlePuzzleCompletion() {
            this.isSolving = true;
            this.score = this.calculateScore();

            // Determine if this is a new best(lower moves)
            const isNewBest = this.bestMoves === null || this.moves < this.bestMoves;

            if (isNewBest) {
                this.bestMoves = this.moves; 
                this.newBest = true;
                
                // For guest users, save to localStorage immediately
                if (!window.isAuthenticated) {
                    await this.saveBestMoves(this.moves);
                }
            }
                    
            const scoreData = {
                moves: this.moves,
                bestMoves: isNewBest ? this.moves : this.bestMoves,
                score: this.score,
                game_id: this.gameId,
                timestamp: new Date().toISOString(),
            };


            try {
                if (window.isAuthenticated) {
                    const success = await this.safeLivewireEmit('game-completed', {data: scoreData});
                
                    if (!success) {
                        this.saveToPending(scoreData);
                       
                    } 
                } else {
                    this.updateLocalBestMoves(scoreData);
                }
            } catch (error) {
                console.error('Completion error:', error);
                // this.showErrorMessage('Error saving score');
            } finally {
                this.isSolving = false;
            }
        },

        async safeLivewireEmit(eventName, data) {
            try {
                if (!window.Livewire) {
                    throw new Error('Livewire not loaded');
                }
                
                return new Promise((resolve) => {
                    const timeout = setTimeout(() => {
                        document.removeEventListener('score-updated', listener);
                        resolve(false);
                    }, 3000);

                    const listener = (event) => {
                        clearTimeout(timeout);
                        resolve(event.detail);
                    };

                    document.addEventListener('score-updated', listener, { once: true });
                    Livewire.dispatch(eventName, data);
                    });
                } 
            catch (error) {
                console.error('Livewire emit error:', error);
                return false;
            }
        },

        // Store pending scores for offline users
        saveToPending(scoreData) {
            const pending = getLocalStorage('pendingScores', []);
            pending.push(scoreData);
            setLocalStorage('pendingScores', pending);
        },

        // Update local storage for guests
        updateLocalBestMoves(scoreData) {
            const guestScores = getLocalStorage('guestScores', {});
            const gameKey = `game_${scoreData.game_id}`;
            
            if (!guestScores[gameKey] || scoreData.moves < guestScores[gameKey].moves) {
                guestScores[gameKey] = {
                    moves: scoreData.moves,
                    score: scoreData.score,
                    timestamp: new Date().toISOString()
                };
                setLocalStorage('guestScores', guestScores);
                this.bestMoves = scoreData.moves;
                this.newBest = true;
            }
        },

        showTemporaryMessage(message) {
            const msg = document.createElement('div');
            msg.textContent = message;
            msg.className = 'fixed top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded';
            document.body.appendChild(msg);
            setTimeout(() => msg.remove(), 3000);
        },

        async loadBestMoves() {

            if (!this.gameId) {
                console.warn('Cannot load best moves: gameId is not set');
                return;
            }

            if (window.isAuthenticated) {

                const listener = (event) => {

                    if (event.detail?.gameId === this.gameId) {
                        // Force Alpine to react
                        this.bestMoves = Number(event.detail.bestMoves);

                        // this.$nextTick(() => {
                        // });

                        window.removeEventListener('best-moves-loaded', listener, { once: true });
                    }
                };

                window.addEventListener('best-moves-loaded', listener, { once: true });

               // Emit to Livewire
                try {
                    Livewire.dispatch('requestBestMoves', { 
                        gameId: this.gameId 
                    });
                } catch (e) {
                    console.error('Error emitting to Livewire:', e);
                }
            }else {
                const bestMoves = JSON.parse(localStorage.getItem('game_best_moves') || '{}');
                this.bestMoves = bestMoves[this.gameId] || this.bestMoves;
            }
            


        },

        async saveBestMoves(moves) {
            const bestMoves = JSON.parse(localStorage.getItem('game_best_moves') || '{}');
            const previousBest = bestMoves[this.gameId] || null;

            if (previousBest === null || moves < previousBest) {
                bestMoves[this.gameId] = moves;
                localStorage.setItem('game_best_moves', JSON.stringify(bestMoves));
                this.bestMoves = moves;
                this.newBest = true;
                setTimeout(() => this.newBest = false, 3000);
            } else {
                this.bestMoves = previousBest;
            }
        },

        
        // Get pending scores
        getPendingScores() {
        return getLocalStorage('pendingScores', []);
        },

        
        // Clear pending scores
        clearPendingScores(gameId = null) {
            if (gameId) {
                const pending = getPendingScores().filter(
                score => score.game_id !== gameId
                );
                setLocalStorage('pendingScores', pending);
            } else {
                localStorage.removeItem('pendingScores');
            }
        },

        

        calculateScore() {
            const totalPaths = Object.keys(this.connections).length;
            const baseScore = totalPaths * 100;
            const penalty = this.moves - totalPaths;
            const finalScore = Math.max(0, baseScore - penalty * 2);
            return finalScore;
        },


        renderAll() {
            this.renderCells();
            this.renderPaths();
        },

        renderCells() {
            this.$refs.cellsGroup.innerHTML = '';
            
            Object.entries(this.connections).forEach(([color, points]) => {
                const startCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                startCircle.setAttribute('cx', points.start[1] * 50 + 26);
                startCircle.setAttribute('cy', points.start[0] * 50 + 26);
                startCircle.setAttribute('r', '15');
                startCircle.setAttribute('fill', color);
                startCircle.classList.add('endpoint', 'cursor-pointer');
                startCircle.setAttribute('data-color', color);
                startCircle.setAttribute('data-row', points.start[0]);
                startCircle.setAttribute('data-col', points.start[1]);
                this.$refs.cellsGroup.appendChild(startCircle);
                
                const endCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                endCircle.setAttribute('cx', points.end[1] * 50 + 26);
                endCircle.setAttribute('cy', points.end[0] * 50 + 26);
                endCircle.setAttribute('r', '15');
                endCircle.setAttribute('fill', color);
                endCircle.classList.add('endpoint', 'cursor-pointer');
                endCircle.setAttribute('data-color', color);
                endCircle.setAttribute('data-row', points.end[0]);
                endCircle.setAttribute('data-col', points.end[1]);
                this.$refs.cellsGroup.appendChild(endCircle);
            });
        },

        renderPaths() {
            this.$refs.pathsGroup.innerHTML = '';
            
            Object.entries(this.userPaths).forEach(([color, path]) => {
                if (path?.length >= 2) {
                    this.renderPathSegments(path, color, '8');
                }
            });
            
            if (this.tempPath?.length > 1) {
                this.renderPathSegments(this.tempPath, this.drawing, '8', '0.7');
            }
        },

        renderPathSegments(path, color, width, opacity = '1') {
            for (let i = 0; i < path.length - 1; i++) {
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', path[i][1] * 50 + 26);
                line.setAttribute('y1', path[i][0] * 50 + 26);
                line.setAttribute('x2', path[i + 1][1] * 50 + 26);
                line.setAttribute('y2', path[i + 1][0] * 50 + 26);
                line.setAttribute('stroke', color);
                line.setAttribute('stroke-width', width);
                line.setAttribute('stroke-linecap', 'round');
                line.setAttribute('opacity', opacity);
                line.classList.add('path-segment');
                this.$refs.pathsGroup.appendChild(line);
            }
        },

        setupEventListeners() {
            const svg = this.$el.querySelector('svg');
            
            svg.addEventListener('mousedown', (e) => {
                const circle = e.target.closest('circle.endpoint');
                if (circle) {
                    const color = circle.getAttribute('data-color');
                    const row = parseInt(circle.getAttribute('data-row'));
                    const col = parseInt(circle.getAttribute('data-col'));
                    
                    if (!this.isPathComplete(color)) {
                        this.startDrawing(color, [row, col]);
                    }
                }
            });

            svg.addEventListener('mousemove', (e) => {
                if (!this.drawing) return;
                const point = this.getMousePosition(e);
                if (point) {
                    this.draw(this.drawing, point);
                }
            });

            svg.addEventListener('mouseup', () => this.stopDrawing());
            svg.addEventListener('mouseleave', () => this.stopDrawing());
        },

        getMousePosition(e) {
            const svg = this.$el.querySelector('svg');
            const pt = svg.createSVGPoint();
            pt.x = e.clientX;
            pt.y = e.clientY;
            const svgP = pt.matrixTransform(svg.getScreenCTM().inverse());
            const col = Math.floor(svgP.x / 50);
            const row = Math.floor(svgP.y / 50);

            if (row >= 0 && row < this.gridSize && col >= 0 && col < this.gridSize) {
                return [row, col];
            }
            return null;
        },

        startDrawing(color, point) {
            if (!this.isValidStart(color, point)) return;
            
            this.drawing = color;
            this.userPaths[color] = [point];
            this.lastPoint = point;
            this.tempPath = [point];
            this.renderPaths();
        },

        draw(color, point) {
            if (this.drawing !== color || !point) return;

            const last = this.lastPoint;
            if (!last) return;

            // Skip if point is same as last
            if (point[0] === last[0] && point[1] === last[1]) return;

            // Must move one cell horizontally or vertically
            const dx = Math.abs(point[0] - last[0]);
            const dy = Math.abs(point[1] - last[1]);
            if (dx + dy !== 1) return;

            // Don't allow drawing if path is complete
            if (this.isPathComplete(color)) return;

            // Check if cell is occupied by another path
            if (this.isCellOccupied(point, color)) return;

            const currentPath = this.userPaths[color] || [];

            const connection = this.connections[color];
            const isConnectingToOtherEndpoint =
                (point[0] === connection.start[0] && point[1] === connection.start[1]) ||
                (point[0] === connection.end[0] && point[1] === connection.end[1]);

            const firstPoint = currentPath[0];
            const isOppositeEndpoint =
                (firstPoint[0] === connection.start[0] && firstPoint[1] === connection.start[1] &&
                point[0] === connection.end[0] && point[1] === connection.end[1]) ||
                (firstPoint[0] === connection.end[0] && firstPoint[1] === connection.end[1] &&
                point[0] === connection.start[0] && point[1] === connection.start[1]);

            // Connect to opposite endpoint and finish path
            if (isConnectingToOtherEndpoint && isOppositeEndpoint) {
                this.userPaths[color] = [...currentPath, point];
                this.moves++;  // Final valid move
                this.lastPoint = point;
                this.tempPath = null;
                this.renderPaths();
                this.checkCompletion();
                return;
            }

            // Avoid looping back or repeating
            const alreadyInPath = currentPath.some(p => p[0] === point[0] && p[1] === point[1]);
            if (alreadyInPath) return;

            // Regular valid step
            this.userPaths[color] = [...currentPath, point];
            this.tempPath = [...(this.tempPath || []), point];
            this.lastPoint = point;
            this.moves++;
            this.renderPaths();
        },

        stopDrawing() {
            if (!this.drawing) return;
            
            const color = this.drawing;
            
            // Only clear the path if it's not complete
            if (!this.isPathComplete(color) && this.tempPath?.length > 1) {
                this.userPaths[color] = [];
                this.moves--; 
            }
            
            this.drawing = null;
            this.lastPoint = null;
            this.tempPath = null;
            this.renderPaths();
            this.checkCompletion();
        },

        isPathComplete(color) {
            const path = this.userPaths[color] || [];
            if (path.length < 2) return false;
            
            const connection = this.connections[color];
            if (!connection) return false;
            
            const firstPoint = path[0];
            const lastPoint = path[path.length - 1];
            
            // Check if path connects start to end
            const startToEnd = 
                firstPoint[0] === connection.start[0] && firstPoint[1] === connection.start[1] &&
                lastPoint[0] === connection.end[0] && lastPoint[1] === connection.end[1];
            
            // Check if path connects end to start
            const endToStart = 
                firstPoint[0] === connection.end[0] && firstPoint[1] === connection.end[1] &&
                lastPoint[0] === connection.start[0] && lastPoint[1] === connection.start[1];
            
            return startToEnd || endToStart;
        },

        isCellOccupied(point, currentColor) {
            for (const [color, path] of Object.entries(this.userPaths)) {
                if (color !== currentColor && path) {
                    for (const p of path) {
                        if (p[0] === point[0] && p[1] === point[1]) {
                            return true;
                        }
                    }
                }
            }
            return false;
        },

        checkCompletion() {
            // Game is only complete when ALL paths are complete and don't intersect
            let allComplete = true;
            const occupiedCells = new Set();
            
            for (const [color, path] of Object.entries(this.userPaths)) {
                if (!this.isPathComplete(color)) {
                    allComplete = false;
                    break;
                }
                
                // Check for intersections (ignore endpoints)
                for (let i = 1; i < path.length - 1; i++) {
                    const cellKey = `${path[i][0]},${path[i][1]}`;
                    if (occupiedCells.has(cellKey)) {
                        allComplete = false;
                        break;
                    }
                    occupiedCells.add(cellKey);
                }
                
                if (!allComplete) break;
            }
            
            // check that all required colors have paths
            if (allComplete) {
                const requiredColors = Object.keys(this.connections);
                const completedColors = Object.keys(this.userPaths);
                allComplete = requiredColors.every(color => completedColors.includes(color));
            }
           
            this.isCompleted = allComplete;
        },

        addPathPoint(color, point) {
            if (!this.userPaths[color]) {
                this.userPaths[color] = [];
            }
            this.userPaths[color].push(point);
            this.incrementMove();
            this.dispatchUpdatePath();
            this.checkCompletion();
        },

        incrementMove() {
            this.moves++;

        },

        isValidStart(color, point) {
            const connection = this.connections[color];
            if (!connection) return false;
            
            const isStart = point[0] === connection.start[0] && point[1] === connection.start[1];
            const isEnd = point[0] === connection.end[0] && point[1] === connection.end[1];
            
            return (isStart || isEnd) && !this.isPathComplete(color);
        },

        resetPuzzle() {
            this.moves = 0;
            this.userPaths = {};
            this.isCompleted = false;
            this.drawing = null;
            this.lastPoint = null;
            this.tempPath = null;
            this.score = null;
            this.cells = JSON.parse(JSON.stringify(this.originalCells));
            this.connections = JSON.parse(JSON.stringify(this.originalConnections));
            this.newBest = false;
            this.renderAll();
        },
    };
}