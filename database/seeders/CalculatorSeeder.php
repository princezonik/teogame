<?php

namespace Database\Seeders;

use App\Models\Calculator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalculatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calculators = [
            [
                'title' => 'Robux to USD Converter',
                'slug' => 'robux-converter',
                'description' => 'Convert Robux to USD',
                'settings' => ['exchange_rate' => 0.005],
            ],
            [
                'title' => 'DPS TTK Calculator',
                'slug' => 'dps-ttk-calculator',
                'description' => 'Damage per Second Time to kill calculator',
                // future: 'settings' => ['weapon_type' => 'rifle']
            ],
            [
                'title' => 'LootDrop Simulator',
                'slug' => 'lootdrop-chance-simulator',
                'description' => 'Simulate game loot drops',
            ],
            [
                'title' => 'Steam Backlog Breakeven Timer', 
                'slug' => 'steam-backlog-calculator', 
                'description' => 'Estimate time to finish your backlog'
            ],
            [
                'title' => 'FPS Budget Estimator', 
                'slug' => 'fps-budget-estimator', 
                'description' => 'Estimate your game FPS'
            ],

            ['title' => 'Craft vs Buy ROI Calculator', 'slug' => 'craft-roi', 'description' => 'Track your XP progress'],
            ['title' => 'Ping to Frame Delay Calculator', 'slug' => 'ping-frame-delay', 'description' => 'Check game ping stats'],
            ['title' => 'Exp to Level ', 'slug' => 'exp-to-level', 'description' => 'Predict your game rank'],
            ['title' => 'Pixel Art Cost', 'slug' => 'pixel-art-cost-estimator', 'description' => 'Simulate fair coin flips'],
            ['title' => 'Twitch Revenue Estimator', 'slug' => 'twitch-revenue-estimator', 'description' => 'Simulate gacha pulls'],
            ['title' => 'vram-fit-checker', 'slug' => 'vram-fit-checker', 'description' => 'Calculate your damage per second'],
            // ['title' => 'vram-fit-checker', 'slug' => 'dps-calculator', 'description' => 'Calculate your damage per second'],

        ];

        foreach ($calculators as $calc) {
            Calculator::create([
                'title' => $calc['title'],
                'slug' => $calc['slug'],
                'description' => $calc['description'],
                'is_visible' => true,
                'settings' => json_encode($calc['settings'] ?? null),
            ]);
        }
    }
}