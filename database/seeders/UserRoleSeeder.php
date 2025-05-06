<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         // Check if an admin exists. If not, create it.
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Check if an admin with this email exists
            [
                'name' => 'Admin User',
                'password' => bcrypt('adminpassword'), // You should ideally change this
                'role' => 'admin', // Assign the 'admin' role
            ]
        );
         // Create an admin user
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('adminpassword'), // Make sure to change this
        //     'role' => 'admin', // Assign role as admin
        // ]);

        // Create regular users
        \App\Models\User::factory(10)->create(); // Creates 10 regular users with default 'user' role

        // Optionally, you can create more users with specific roles
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user', // Assign regular user role
        ]);
    }
}
