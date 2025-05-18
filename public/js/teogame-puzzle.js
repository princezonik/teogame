function puzzleBoard(data) {
    return {
        gridSize: data.gridSize || 5,
        cells: data.cells || {},
        connections: data.connections || {},
        userPaths: data.userPaths || {},
        isCompleted: data.isCompleted || false,
        drawing: null,
        lastPoint: null,
        tempPath: null,
        animationFrame: null,

        init() {
            this.renderAll();
            this.setupEventListeners();
        },

        renderAll() {
            this.renderCells();
            this.renderPaths();
        },

        renderCells() {
            const cellsGroup = this.$refs.cellsGroup;
            cellsGroup.innerHTML = '';
            
            Object.values(this.cells).forEach(cell => {
                if (!cell) return;
                
                const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                circle.setAttribute('cx', cell.col * 50 + 26);
                circle.setAttribute('cy', cell.row * 50 + 26);
                circle.setAttribute('r', '15');
                circle.setAttribute('fill', cell.color);
                circle.classList.add('endpoint', 'cursor-pointer');
                circle.setAttribute('data-color', cell.color);
                circle.setAttribute('data-row', cell.row);
                circle.setAttribute('data-col', cell.col);
                
                cellsGroup.appendChild(circle);
            });
        },

        renderPaths() {
            const pathsGroup = this.$refs.pathsGroup;
            pathsGroup.innerHTML = '';
            
            // Render permanent paths
            Object.entries(this.userPaths).forEach(([color, path]) => {
                if (!path || path.length < 2) return;
                this.renderPathSegments(pathsGroup, path, color, '8');
            });
            
            // Render temporary path (visual feedback)
            if (this.tempPath && this.tempPath.length > 1) {
                this.renderPathSegments(pathsGroup, this.tempPath, this.drawing, '8', '0.7');
            }
        },

        renderPathSegments(container, path, color, width, opacity = '1') {
            for (let i = 0; i < path.length - 1; i++) {
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', path[i][1] * 50 + 26);
                line.setAttribute('y1', path[i][0] * 50 + 26);
                line.setAttribute('x2', path[i+1][1] * 50 + 26);
                line.setAttribute('y2', path[i+1][0] * 50 + 26);
                line.setAttribute('stroke', color);
                line.setAttribute('stroke-width', width);
                line.setAttribute('stroke-linecap', 'round');
                line.setAttribute('opacity', opacity);
                line.classList.add('path-segment');
                container.appendChild(line);
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
                    this.startDrawing(color, [row, col]);
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
            if (this.isValidStart(color, point)) {
                this.drawing = color;
                this.userPaths = {...this.userPaths, [color]: [point]};
                this.lastPoint = point;
                this.tempPath = [point];
                this.renderPaths();
            }
        },

        draw(color, point) {
            if (this.drawing !== color || !this.isValidMove(point)) return;
            
            // Add intermediate points for smooth drawing
            const last = this.lastPoint;
            const dx = point[0] - last[0];
            const dy = point[1] - last[1];
            
            if (dx !== 0 && dy !== 0) return; // Diagonal move
            
            // Add all intermediate cells
            if (dx !== 0) {
                const step = dx > 0 ? 1 : -1;
                for (let row = last[0] + step; row !== point[0]; row += step) {
                    this.addToPath(color, [row, last[1]]);
                }
            } else {
                const step = dy > 0 ? 1 : -1;
                for (let col = last[1] + step; col !== point[1]; col += step) {
                    this.addToPath(color, [last[0], col]);
                }
            }
            
            this.addToPath(color, point);
            this.renderPaths();
        },

        addToPath(color, point) {
            if (!this.isValidMove(point)) return;
            
            const currentPath = this.userPaths[color] || [];
            this.userPaths = {...this.userPaths, [color]: [...currentPath, point]};
            this.tempPath = [...(this.tempPath || []), point];
            this.lastPoint = point;
        },

        stopDrawing() {
            if (!this.drawing) return;
            
            const color = this.drawing;
            const path = this.userPaths[color] || [];
            const connection = this.connections[color];
            
            if (connection) {
                const lastPoint = path[path.length - 1];
                const isValidEnd = (
                    (lastPoint[0] === connection.end[0] && lastPoint[1] === connection.end[1]) ||
                    (lastPoint[0] === connection.start[0] && lastPoint[1] === connection.start[1])
                );
                
                if (!isValidEnd) {
                    this.userPaths = {...this.userPaths, [color]: []};
                }
            }
            
            this.drawing = null;
            this.lastPoint = null;
            this.tempPath = null;
            this.renderPaths();
            this.checkCompletion(); // Now this will work
        },

        checkCompletion() {
            let allCompleted = true;
            
            for (const [color, connection] of Object.entries(this.connections)) {
                const path = this.userPaths[color] || [];
                if (path.length < 2) {
                    allCompleted = false;
                    break;
                }
                
                const startMatch = (path[0][0] === connection.start[0] && path[0][1] === connection.start[1]) &&
                                 (path[path.length-1][0] === connection.end[0] && path[path.length-1][1] === connection.end[1]);
                
                const reverseMatch = (path[0][0] === connection.end[0] && path[0][1] === connection.end[1]) &&
                                    (path[path.length-1][0] === connection.start[0] && path[path.length-1][1] === connection.start[1]);
                
                if (!(startMatch || reverseMatch)) {
                    allCompleted = false;
                    break;
                }
            }
            
            this.isCompleted = allCompleted;
            
            if (this.isCompleted) {
                // Use dispatch instead of direct Livewire call
                this.$dispatch('puzzle-completed');
            }
        },

        isValidStart(color, point) {
            const connection = this.connections[color];
            if (!connection) return false;
            
            return (
                (point[0] === connection.start[0] && point[1] === connection.start[1]) ||
                (point[0] === connection.end[0] && point[1] === connection.end[1])
            );
        },

        isValidMove(point) {
            if (!this.lastPoint) return false;
            
            const dx = Math.abs(point[0] - this.lastPoint[0]);
            const dy = Math.abs(point[1] - this.lastPoint[1]);
            if (dx + dy !== 1) return false;
            
            if (point[0] < 0 || point[0] >= this.gridSize || point[1] < 0 || point[1] >= this.gridSize) {
                return false;
            }
            
            for (const [pathColor, path] of Object.entries(this.userPaths)) {
                if (pathColor !== this.drawing) {
                    for (const p of path || []) {
                        if (p[0] === point[0] && p[1] === point[1]) {
                            return false;
                        }
                    }
                }
            }
            
            return true;
        },

        resetPuzzle() {
            this.userPaths = {};
            this.isCompleted = false;
            this.drawing = null;
            this.lastPoint = null;
            this.tempPath = null;
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
                this.animationFrame = null;
            }
            this.renderPaths();
            this.$dispatch('puzzle-reset');
        }
    };
}