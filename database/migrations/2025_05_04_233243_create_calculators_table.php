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
        Schema::create('calculators', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // for routing, e.g., robux-usd
            $table->text('description')->nullable(); // short explanation for users
            $table->string('icon')->nullable(); // optional, for UI
            $table->boolean('is_visible')->default(true); // visibility toggle
            $table->json('settings')->nullable(); // optional: store extra config per calculator
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculators');
    }
};
