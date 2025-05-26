window.initializeEcho = function() {
    const gameId = window.gameId || null;
    if (gameId) {
        console.log('Subscribing to leaderboard.' + gameId);
        window.Echo.private(`leaderboard.${gameId}`)
            .listen('.ScoreUpdated', (e) => {
                console.log('Score updated for game:', e.game_id, 'difficulty:', e.difficulty);
                fetchLeaderboard(gameId, e.difficulty);
            });
    } else {
        console.warn('window.gameId is undefined, skipping game-specific leaderboard subscription');
    }

    window.Echo.private('leaderboard')
        .listen('.ScoreUpdated', (event) => {
            console.log('Global leaderboard update');
            fetchLeaderboard(gameId);
        });
};


function fetchLeaderboard(gameId, difficulty = null) {

    const url = '/leaderboard/refresh';
    const params = new URLSearchParams({ game_id: gameId });
    
    if (difficulty) {
        params.append('difficulty', difficulty);
    }

    fetch(`${url}?${params.toString()}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        updateLeaderboardDOM(data.scores);
    })
    .catch(error => {
        console.error('Error refreshing leaderboard:', error);
    });
}

function updateLeaderboardDOM(scores) {
    const tableBody = document.querySelector('#leaderboard-table tbody');
    tableBody.innerHTML = scores.map(score => `
        <tr>
            <td class="p-2">${score.user_name}</td>
            <td class="p-2">${score.score}</td>
            <td class="p-2">${score.best_moves || 'N/A'}</td>
        </tr>
    `).join('');
}

function handleResponse(response) {
    if (!response.ok) throw new Error('Network response was not ok');
    return response.json();
}

function handleError(error) {
    console.error('Leaderboard fetch failed:', error);
}
