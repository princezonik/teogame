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
            UserScoreSeeder::class,
        ]);

        // Call the RoleSeeder to populate the roles table
        $this->call([
            RoleSeeder::class,
        ]);

        $this->call([
            UserRoleSeeder::class, // Register the UserRoleSeeder
        ]);
        $this->call([
            FpsEstimatorSeeder::class, // Register the UserRoleSeeder
        ]);
        $this->call([
           PuzzleSeeder::class, // Register the UserRoleSeeder
        ]);
    }
}
