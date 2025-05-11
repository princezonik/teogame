// public/js/maze-game.js

document.addEventListener('DOMContentLoaded', () => {
    const moveSound = document.getElementById('move-sound');
    const winSound = document.getElementById('win-sound');

    // Arrow key movement
    window.addEventListener('keydown', (e) => {
        const keyMap = {
            ArrowUp: 'up',
            ArrowDown: 'down',
            ArrowLeft: 'left',
            ArrowRight: 'right'
        };

        const direction = keyMap[e.key];
        if (direction) {
            e.preventDefault();
            if (moveSound) moveSound.play();
            window.Livewire.dispatch('move', { direction });
        }
    });

    // Win condition handler
    window.Livewire.on('levelCompleted', () => {
        if (winSound) winSound.play();
    });
});
