<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    
   public function index(){
    
    $tools = [
        ['name' => 'Robux ↔ USD', 'slug' => 'robux-usd', 'description' => 'Convert Robux to USD and vice versa.'],
        ['name' => 'DPS → TTK', 'slug' => 'dps-ttk', 'description' => 'Calculate kill time from DPS and HP.'],
        ['name' => 'LootDrop Chance Simulator', 'slug' => 'loot-drop-chance', 'description' => 'Simulate odds of rare item drops.'],
        ['name' => 'Steam Backlog Timer', 'slug' => 'steam-backlog', 'description' => 'Estimate when you’ll finish your backlog.'],
        ['name' => 'FPS Budget Estimator', 'slug' => 'fps-budget', 'description' => 'Estimate FPS by hardware and game.'],
        ['name' => 'Ping to Frame Delay', 'slug' => 'ping-delay', 'description' => 'Convert ping to frame delay.'],
        ['name' => 'EXP to Next Level', 'slug' => 'exp-needed', 'description' => 'How much EXP to reach a level.'],
        ['name' => 'PixelArt Cost Estimator', 'slug' => 'pixel-art-cost', 'description' => 'Estimate pixel art sheet costs.'],
        ['name' => 'Twitch Revenue Estimator', 'slug' => 'twitch-revenue', 'description' => 'Predict Twitch income.'],
        ['name' => 'VRAM Fit Checker', 'slug' => 'vram-fit', 'description' => 'See if your GPU can handle a texture pack.'],
        ['name' => 'Craft vs Buy ROI', 'slug' => 'craft-buy-roi', 'description' => 'Compare crafting cost vs market price.'],
        ['name' => 'Electricity Cost Calculator', 'slug' => 'gaming-electricity', 'description' => 'Gaming power cost per hour/day/month.'],
    ];

    return view('tools.index', compact('tools'));
   }
}
