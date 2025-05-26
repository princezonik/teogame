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
            'title' => '2048',
            'image' => 'images/puzzle2048.png',
            'description' => 'The 2048 game is a popular single-player sliding puzzle game where the objective is to combine like-numbered tiles to create a tile with the number 2048. The game is played on a 4x4 grid, and the player can slide tiles in four directions (up, down, left, or right). Each move merges two tiles with the same number into one, and new tiles (usually with the value of 2 or 4) appear on the grid after each move. The game ends when the player creates a tile with the number 2048 or when the grid fills up and no more moves are possible.',
            'slug' => 'game2048'
        ],

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
        [
            'title' => '[🌙] Grow a Garden 🌻',
            'image' => 'images/grow.jpg',
            'description' => 'this is the long ass description of the game',
            'slug' => 'game'
        ],
        [
            'title' => '[🌙] Grow a Garden 🌻',
            'image' => 'images/grow.jpg',
            'description' => 'this is the long ass description of the game',
            'slug' => 'games'
        ],
        
    ]);
    }
}
