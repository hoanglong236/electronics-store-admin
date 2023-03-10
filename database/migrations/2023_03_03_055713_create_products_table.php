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
            $table->integer('category_id')->unsigned()->reference('id')->on('categories');
            $table->integer('brand_id')->unsigned()->reference('id')->on('brands');
            $table->string('name', 128);
            $table->integer('price')->unsigned();
            $table->smallInteger('discount_percent')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->smallInteger('warranty_period')->unsigned();
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
