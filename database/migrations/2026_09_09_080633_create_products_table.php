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
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('brand');
            $table->string('name');
            $table->string('image');
            $table->string('position')->default('center');
            $table->string('status')->default('CÓ SẴN');
            $table->unsignedBigInteger('rental_price');
            $table->unsignedBigInteger('deposit');
            $table->unsignedBigInteger('purchase_price');
            $table->json('sizes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
