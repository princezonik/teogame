<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('puzzle_cells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade'); // Links to the puzzles table
            $table->integer('row'); // Row index of the cell
            $table->integer('col'); // Column index of the cell
            $table->string('value')->nullable(); // Stores the value of the cell, e.g., 'X' or 'A' (can be null)
            $table->string('color')->nullable(); // If a cell has a color, it would be stored here (optional for Flow Free)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puzzle_cells');
    }
};
