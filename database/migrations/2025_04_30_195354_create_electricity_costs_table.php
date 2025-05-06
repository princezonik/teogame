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
        Schema::create('electricity_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('wattage');
            $table->decimal('rate_per_kwh', 5, 2);
            $table->decimal('hours_per_day', 4, 2);
            $table->decimal('cost_per_hour', 6, 4);
            $table->decimal('cost_per_day', 6, 4);
            $table->decimal('cost_per_month', 7, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_costs');
    }
};
