<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Score;


class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create 30 users with random scores
        for($i = 1; $i <= 30; $i++){
            $user = User::create([ 'name' => "Player $i", 'email' => "player$i@example.com", 'password' => bcrypt('password')]);

            Score::create(['user_id' => $user->id, 'score' => rand(100, 1000), 'game_name' => 'Game1']);
        }
    }
}
