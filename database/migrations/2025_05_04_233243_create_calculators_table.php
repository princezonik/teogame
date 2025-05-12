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
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->nullable(); // Type of the calculator (e.g., 'loot simulator')
            $table->json('parameters')->nullable(); // Specific parameters for each calculator
            $table->string('version')->default('1.0'); // Versioning
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status of the calculator
            $table->enum('user_role', ['guest', 'user', 'admin'])->default('guest'); // User permissions
            $table->json('input_formats')->nullable(); // Supported input formats
            $table->json('output_formats')->nullable(); // Supported output formats
            $table->integer('display_order')->default(0); // Display order
            $table->json('settings')->nullable(); // Additional settings in JSON format
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('fields');
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
