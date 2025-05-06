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
        Schema::create('loot_drop_simulations', function (Blueprint $table) {
            $table->id();
            $table->float('probability', 8, 4);  // Single draw probability (0 to 1)
            $table->integer('pulls');  // Number of pulls
            $table->float('loot_drop_chance', 8, 4);  // Cumulative chance in percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loot_drop_simulations');
    }
};
