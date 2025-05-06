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
        Schema::create('crafting_decisions', function (Blueprint $table) {
            $table->id();
            $table->decimal('material_cost', 10, 2);
            $table->decimal('market_price', 10, 2);
            $table->decimal('roi_percentage', 6, 2);
            $table->string('recommendation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crafting_decisions');
    }
};
