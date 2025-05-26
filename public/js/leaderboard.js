
// window.Echo.private(`leaderboard.${window.gameId}`)
//     .listen('.ScoreUpdated', (e) => {
//         console.log('Score updated for game:', e.game_id);
//         fetchLeaderboard();
// });

// function fetchLeaderboard() {
//     fetch('/leaderboard/refresh', {
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({ game_id: window.gameId })
//     })
//     .then(res => {
//         if (!res.ok) throw new Error(`Network response was not ok: ${res.status}`);
//         return res.json();
//     })
//     .then(data => {
//         updateLeaderboardDOM(data.scores);
//     })
//     .catch(error => {
//         console.error('Error fetching leaderboard:', error);
//     });
// }

// function updateLeaderboardDOM(scores) {
//     const table = document.querySelector('#leaderboard-table tbody');
//     table.innerHTML = '';

//     const fragment = document.createDocumentFragment();
//     scores.forEach(score => {
//         const row = document.createElement('tr');
        
//         const userNameCell = document.createElement('td');
//         userNameCell.textContent = score.user_name;
        
//         const scoreCell = document.createElement('td');
//         scoreCell.textContent = score.score;

//         row.appendChild(userNameCell);
//         row.appendChild(scoreCell);
//         fragment.appendChild(row);
//     });

//     table.appendChild(fragment);
// }