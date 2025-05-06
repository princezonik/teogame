<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            $user->score = rand(0, 1000); // Assign random score
            $user->save();
        });

        // User::factory()->count(100)->create([
        //     'score' => fn() => rand(0, 1000),
        // ]);
    }
}
