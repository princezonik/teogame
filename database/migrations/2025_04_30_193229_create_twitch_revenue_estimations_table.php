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
        Schema::create('twitch_revenue_estimations', function (Blueprint $table) {
            $table->id();
            $table->integer('tier1_subs');
            $table->integer('bits');
            $table->integer('ad_views');
            $table->decimal('estimated_revenue', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitch_revenue_estimations');
    }
};
