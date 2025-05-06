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
        Schema::create('steam_backlogs', function (Blueprint $table) {
            $table->id();
            $table->float('total_backlog_hours', 8, 2);  // Total backlog hours
            $table->float('average_weekly_playtime', 8, 2);  // Average weekly playtime in hours
            $table->float('days_to_finish', 8, 2)->nullable();  // Estimated days to finish backlog
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam_backlogs');
    }
};
