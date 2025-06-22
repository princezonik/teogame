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
        Schema::table('scores', function (Blueprint $table) {
            $table->boolean('is_flagged')->default(false)->after('moves');
            $table->text('flagged_reason')->nullable()->after('is_flagged');
            $table->timestamp('flagged_at')->nullable()->after('flagged_reason');
            $table->foreignId('flagged_by')->nullable()->constrained('users')->after('flagged_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            //
        });
    }
};
