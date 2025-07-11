<?php

namespace Database\Seeders;

use App\Models\FpsBenchmark;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(UserSeeder::class);

        $this->call([
            AdminSeeder::class,
        ]);
       
        $this->call([
            RoleSeeder::class,
        ]);

        $this->call([
            UserRoleSeeder::class,
        ]);
        $this->call([
            FpsEstimatorSeeder::class,
        ]);
        $this->call([
           PuzzleSeeder::class, 
        ]);

         $this->call([
           GameSeeder::class, 
         ]);
        $this->call([
           ScoreSeeder::class, 
        ]);
        $this->call([
           CalculatorSeeder::class, 
        ]);
       
    }
}
