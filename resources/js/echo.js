
Echo.private('leaderboard').listen('.ScoreUpdated', (e) => {
    console.log('Score updated', e);
    fetchLeaderboard();
});

function fetchLeaderboard() {
    fetch('/leaderboard/refresh', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        updateLeaderboardDOM(data.scores);
    });
}

// Laravel Echo listens for ScoreUpdated events
Echo.private('leaderboard').listen('.ScoreUpdated', (event) => {
    // Fetch updated leaderboard from server
    fetch('/leaderboard/refresh').then(response => response.json()).then(data => {
        updateLeaderboard(data.scores);
    });
});

// Function to update the leaderboard table
function updateLeaderboardDOM(scores) {
    const table = document.querySelector('#leaderboard-table tbody');
    
    // Clear the existing rows in the table body
    table.innerHTML = '';

    // Use a fragment to build the rows in memory
    const fragment = document.createDocumentFragment();

    // Loop through the scores and create table rows
    scores.forEach(score => {
        const row = document.createElement('tr');
        
        const userNameCell = document.createElement('td');
        userNameCell.textContent = score.user_name;
        
        const scoreCell = document.createElement('td');
        scoreCell.textContent = score.score;

        // Append the cells to the row
        row.appendChild(userNameCell);
        row.appendChild(scoreCell);

        // Append the row to the fragment (in memory)
        fragment.appendChild(row);
    });

    // Append the entire fragment to the table at once
    table.appendChild(fragment);
}

