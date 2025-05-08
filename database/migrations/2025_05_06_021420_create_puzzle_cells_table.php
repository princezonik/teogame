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
            $table->foreignId('puzzle_id')->constrained()->onDelete('cascade');
            $table->integer('row'); // Row index (0–4)
            $table->integer('col'); // Column index (0–4)
            $table->string('color')->nullable(); // Color of dot (e.g., "red") or null for empty
            $table->timestamps();
            $table->index(['puzzle_id', 'row', 'col']); // Optimize grid queries
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
