<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Score;
use App\Models\Game;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Get all games in the database
    $games = Game::all();

    // Create a random number of users (for example, between 10 and 30 users)
    $numUsers = rand(10, 30);

    // Create random users and assign random scores to each game
    for ($i = 1; $i <= $numUsers; $i++) {
        $user = User::create([
            'name' => "Player $i",
            'email' => "player$i@example.com",
            'password' => bcrypt('password')
        ]);

        // Loop through all the games and create random scores for each game
        foreach ($games as $game) {
            Score::create([
                'user_id' => $user->id,
                'game_id' => $game->id,  
                'score' => rand(10, 100),  
                'moves' => rand(30, 70),
                'best_moves' => rand(10, 70),
                'time' => 300,
            ]);
        }
    }
    }
}
