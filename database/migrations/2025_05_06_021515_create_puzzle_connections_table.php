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
        Schema::create('puzzle_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade'); // Links to the puzzles table
            $table->foreignId('start_cell_id')->constrained('puzzle_cells')->onDelete('cascade'); // Start cell of the connection
            $table->foreignId('end_cell_id')->constrained('puzzle_cells')->onDelete('cascade'); // End cell of the connection
            $table->string('color'); // Color of the connection (e.g., "red", "blue")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puzzle_connections');
    }
};
