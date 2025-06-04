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
};


function fetchLeaderboard(gameId, difficulty = null, e = null) {
    
    Livewire.dispatch('setGameId', { gameId, slug: null, difficulty });

    if (e) {

        console.log('dispatching to laravel')
        Livewire.dispatch('ScoreUpdated', {
            user_id: e.user_id,
            user_name: e.user_name,
            score: e.score,
            game_id: e.game_id
        });
    }

}

function handleResponse(response) {
    if (!response.ok) throw new Error('Network response was not ok');
    return response.json();
}

function handleError(error) {
    console.error('Leaderboard fetch failed:', error);
}
