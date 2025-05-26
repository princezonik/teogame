
document.addEventListener('alpine:init', () => {
    console.log('Alpine:init triggered, registering puzzleGame');
    Alpine.data('puzzleGame', (puzzle) => ({
        puzzle: puzzle || {},
        paths: {},
        currentPath: null,
        isDrawing: false,
        timer: 0,
        timerInterval: null,
        timerDisplay: '0:00.000',
        history: [],

        init() {
            console.log('PuzzleGame init', this.puzzle);
            if (!this.puzzle || !this.puzzle.connections) {
                console.error('Invalid puzzle data');
                this.timerDisplay = 'Error';
                return;
            }
            this.puzzle.connections.forEach(conn => {
                this.paths[conn.color] = [];
            });
            this.$watch('isDrawing', (value) => {
                if (value && !this.timerInterval) {
                    this.timerInterval = setInterval(() => {
                        this.timer += 10;
                        this.updateTimerDisplay();
                    }, 10);
                }
            });
        },

        getCellClass(row, col) {
            let classes = [];
            Object.values(this.paths).forEach(path => {
                if (path.some(p => p[0] === row && p[1] === col)) {
                    classes.push('bg-gray-200');
                }
            });
            return classes;
        },

        cellColor(row, col) {
            const cell = this.puzzle.cells?.find(c => c.row === row && c.col === col) || {};
            return cell.color || '';
        },

        startDrawing(row, col) {
            const cell = this.puzzle.cells?.find(c => c.row === row && c.col === col);
            if (!cell) return;
            this.isDrawing = true;
            this.currentPath = {
                color: cell.color,
                path: [[row, col]]
            };
        },

        drawPath(row, col) {
            if (!this.isDrawing || !this.currentPath) return;
            const lastPoint = this.currentPath.path[this.currentPath.path.length - 1];
            const dx = Math.abs(row - lastPoint[0]);
            const dy = Math.abs(col - lastPoint[1]);
            if (dx + dy === 1 && this.isValidMove(row, col)) {
                this.currentPath.path.push([row, col]);
                this.paths[this.currentPath.color] = [...this.currentPath.path];
                this.history.push({ color: this.currentPath.color, path: [...this.currentPath.path] });
            }
        },

        stopDrawing() {
            if (this.isDrawing) {
                this.validateCurrentPath();
                this.currentPath = null;
                this.isDrawing = false;
            }
        },

        isValidMove(row, col) {
            if (row < 0 || row >= (this.puzzle.grid_size || 5) || col < 0 || col >= (this.puzzle.grid_size || 5)) {
                return false;
            }
            const isEndpoint = this.puzzle.cells?.some(c => c.row === row && c.col === col) || false;
            if (!isEndpoint) {
                for (let color in this.paths) {
                    if (color !== this.currentPath.color && this.paths[color].some(p => p[0] === row && p[1] === col)) {
                        return false;
                    }
                }
            }
            return true;
        },

        validateCurrentPath() {
            if (!this.currentPath) return;
            const color = this.currentPath.color;
            const path = this.currentPath.path;
            const connection = this.puzzle.connections?.find(c => c.color === color);
            const startCell = this.puzzle.cells?.find(c => c.id === connection?.start_cell_id);
            const endCell = this.puzzle.cells?.find(c => c.id === connection?.end_cell_id);
            const pathStart = path[0];
            const pathEnd = path[path.length - 1];
            if (
                !(startCell && endCell &&
                  pathStart[0] === startCell.row && pathStart[1] === startCell.col &&
                  pathEnd[0] === endCell.row && pathEnd[1] === endCell.col)
            ) {
                this.paths[color] = [];
                this.history.push({ color, path: [] });
            }
        },

        renderPaths() {
            console.log('Rendering paths', this.paths);
            let paths = '';
            for (let color in this.paths) {
                const path = this.paths[color];
                if (path.length < 2) continue;
                let d = `M${path[0][1] * 100 + 50},${path[0][0] * 100 + 50}`;
                for (let i = 1; i < path.length; i++) {
                    d += ` L${path[i][1] * 100 + 50},${path[i][0] * 100 + 50}`;
                }
                paths += `<path d="${d}" stroke="${color}" stroke-width="20" fill="none" stroke-linecap="round" stroke-linejoin="round"/>`;
            }
            return paths;
        },

        get isComplete() {
            return this.puzzle.connections?.every(conn => {
                const path = this.paths[conn.color] || [];
                if (path.length < 2) return false;
                const startCell = this.puzzle.cells?.find(c => c.id === conn.start_cell_id);
                const endCell = this.puzzle.cells?.find(c => c.id === conn.end_cell_id);
                return startCell && endCell &&
                       path[0][0] === startCell.row && path[0][1] === startCell.col &&
                       path[path.length - 1][0] === endCell.row && path[path.length - 1][1] === endCell.col;
            }) || false;
        },

        submitSolution() {
            if (!this.isComplete) return;
            clearInterval(this.timerInterval);
            const moveList = Object.entries(this.paths).map(([color, path]) => ({
                color,
                path: path.map(p => [p[1], p[0]])
            }));
            window.axios.post('/api/attempts', {
                puzzle_id: this.puzzle.id,
                move_list: moveList,
                time_ms: this.timer
            }).then(response => {
                alert(response.data.message);
                window.location.reload();
            }).catch(error => {
                alert('Error submitting solution: ' + (error.response?.data?.message || error.message));
            });
        },

        reset() {
            this.paths = {};
            this.puzzle.connections?.forEach(conn => {
                this.paths[conn.color] = [];
            });
            this.currentPath = null;
            this.isDrawing = false;
            this.history = [];
            this.timer = 0;
            this.updateTimerDisplay();
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        },

        undo() {
            if (this.history.length === 0) return;
            const lastAction = this.history.pop();
            this.paths[lastAction.color] = lastAction.path.length > 0 ? [...lastAction.path] : [];
        },

        updateTimerDisplay() {
            const ms = this.timer % 1000;
            const s = Math.floor(this.timer / 1000) % 60;
            const m = Math.floor(this.timer / 60000);
            this.timerDisplay = `${m}:${s.toString().padStart(2, '0')}.${ms.toString().padStart(3, '0')}`;
        }
    }));
});


function puzzleGame() {
    return {
        moves: 0,
        bestMoves: null,
        isCompleted: false,
        
        init() {
            this.bestMoves = this.getStoredBestMoves();
            window.addEventListener('beforeunload', () => this.storeGuestProgress());
        },
        
        incrementMoves() {
            this.moves++;
            this.$dispatch('move-made');
        },

         // Called whenever user makes a valid move
        handleMove() {
            this.moves++;
            this.$wire.incrementMoves();
        }
        // completeGame() {
        //     this.isCompleted = true;
        //     // this.$dispatch('game-completed');
            
        //     // Update best moves if current is better
        //     if (this.bestMoves === null || this.moves < this.bestMoves) {
        //         this.bestMoves = this.moves;
        //         this.storeBestMoves();
        //     }
        // },

        // Called when puzzle is solved
        handleGameComplete() {
            this.isCompleted = true;
            this.$wire.completeGame();
            
            // Update best moves if needed
            if (this.bestMoves === null || this.moves < this.bestMoves) {
                this.bestMoves = this.moves;
                this.$wire.call('updateBestMoves', this.bestMoves);
            }
            
            // Show completion modal
            this.showCompletionModal = true;
        },
        
        getStoredBestMoves() {
            if (@json(auth()->check())) return null;
            
            const cookieValue = document.cookie
                .split('; ')
                .find(row => row.startsWith('game_best_moves='))
                ?.split('=')[1];
                
            return cookieValue ? JSON.parse(cookieValue)[@json($game->id)] : null;
        },
        
        storeBestMoves() {
            if (@json(auth()->check())) return;
            
            const current = JSON.parse(localStorage.getItem('game_best_moves') || {});
            current[@json($game->id)] = this.bestMoves;
            localStorage.setItem('game_best_moves', JSON.stringify(current));
            
            // Also set cookie for server-side access
            document.cookie = `game_best_moves=${JSON.stringify(current)}; path=/; max-age=${60*60*24*365}`;
        },
        
        storeGuestProgress() {
            if (!this.isCompleted && @json(!auth()->check())) {
                localStorage.setItem('game_current_progress', JSON.stringify({
                    gameId: @json($game->id),
                    moves: this.moves
                }));
            }
        },
        
        resetGame() {
            this.moves = 0;
            this.isCompleted = false;
        }
    };
}