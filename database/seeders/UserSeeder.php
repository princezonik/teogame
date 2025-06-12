<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::updateOrCreate(
            ['email' => 'efik.uprince@gmail.com'], // Unique identifier
            [
                'name' => 'Efik',
                'password' => '12345678',
                'role' => 'admin',
            ],

        );
        User::updateOrCreate(
            ['email' => 'princezonik@gmail.com'],
            [
                'name' => 'Prince',
                'password' => '12345678',
                'role' => 'admin',
            ],

        );
        User::factory()->count(10)->create();
    }
}
