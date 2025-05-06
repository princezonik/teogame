<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FpsEstimatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'game_title' => 'Cyberpunk 2077',
                'cpu_model' => 'Intel Core i7-9700K',
                'gpu_model' => 'NVIDIA RTX 3070',
                'average_fps' => 65,
                'resolution' => '1080p',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'game_title' => 'Elden Ring',
                'cpu_model' => 'Ryzen 5 5600X',
                'gpu_model' => 'NVIDIA RTX 3060 Ti',
                'average_fps' => 72,
                'resolution' => '1440p',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('fps_benchmarks')->insert($data);
    }
}
