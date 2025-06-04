<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;


class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::insert([

            [
                'title' => 'Color Pipes',
                'image' => 'images/colorpipes.webp',
                'description' => 'Color Pipes is a fun and engaging puzzle game that challenges players to connect colored pipes on a grid. The goal of the game is to connect matching colors with pipes, without letting the pipes cross each other. The game is typically played on a grid where the player must fill all the empty spaces by creating paths between colored dots.',
                'slug' => 'teogame-puzzle'
            ],
            [
                'title' => 'Sliding Puzzle',
                'image' => 'images/slidingpuzzle.jpg',
                'description' => 'A Sliding Puzzle (also known as a 15 Puzzle, 15-Slide, or Sliding Tile Puzzle) is a classic puzzle game where the goal is to rearrange tiles on a grid to achieve a specific final configuration. The puzzle consists of a set of numbered tiles arranged in a grid, with one empty space that allows the tiles to be moved by sliding them into the vacant spot.',
                'slug' => 'sliding-puzzle'
            ],
        
        
        ]);
    }
}
