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
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade');
            $table->foreignId('start_cell_id')->constrained('puzzle_cells')->onDelete('cascade');
            $table->foreignId('end_cell_id')->constrained('puzzle_cells')->onDelete('cascade');
            $table->string('color'); // Connection color (e.g., "red")
            $table->json('path')->nullable(); // Optional: Store valid path as JSON
            $table->timestamps();
            $table->index(['puzzle_id', 'color']);
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
