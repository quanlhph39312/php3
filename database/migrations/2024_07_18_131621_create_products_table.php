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
            $table->string('name')->unique();
            $table->foreignId('category_id')->constrained();
            $table->string('image_thumbnail');
            $table->double('price_regular')->nullable();
            $table->double('price_sale')->nullable();
            $table->integer('quantity')->default(0);
            $table->bigInteger('view')->default(0);
            $table->longText('content')->nullable();
            $table->string('description')->nullable();
            $table->string('material')->nullable();
            $table->boolean('is_show_home')->default(true);
            $table->boolean('is_new')->default(true);
            $table->boolean('is_trending')->default(true);
            $table->boolean('is_sale')->default(true);
            $table->boolean('status')->default(true);
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
