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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('height_cm')->nullable();
            $table->unsignedInteger('weight_kg')->nullable();
            $table->unsignedInteger('bust_cm')->nullable();
            $table->unsignedInteger('waist_cm')->nullable();
            $table->unsignedInteger('hips_cm')->nullable();
            $table->json('style_preferences')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
