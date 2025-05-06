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
        Schema::create('fps_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->string('game_title');
            $table->string('cpu_model');
            $table->string('gpu_model');
            $table->unsignedInteger('average_fps');
            $table->string('resolution'); // e.g. '1080p', '1440p', '4K'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fps_benchmarks');
    }
};
