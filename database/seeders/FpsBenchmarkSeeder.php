<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FpsBenchmark;

class FpsBenchmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FpsBenchmark::insert([
            [
                'cpu' => 'Ryzen 5 5600X',
                'gpu' => 'RTX 3060',
                'game' => 'Cyberpunk 2077',
                'average_fps' => 55,
            ],
            [
                'cpu' => 'Intel i5-12400F',
                'gpu' => 'RTX 4060 Ti',
                'game' => 'Fortnite',
                'average_fps' => 180,
            ]
        ]);
    }
}
