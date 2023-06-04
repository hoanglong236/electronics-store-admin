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
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('name', 128);
            $table->string('slug', 128);
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('discount_percent');
            $table->unsignedInteger('quantity');
            $table->unsignedTinyInteger('warranty_period');
            $table->string('description')->nullable();
            $table->string('main_image_path');
            $table->boolean('delete_flag')->default(false);
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
