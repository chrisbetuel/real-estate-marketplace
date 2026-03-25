<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['sale', 'rent'])->default('sale');
            $table->string('category')->nullable();
            $table->decimal('price_sale', 10, 2)->nullable();
            $table->decimal('price_rent', 10, 2)->nullable();
            $table->enum('rent_period', ['day', 'week', 'month', 'year'])->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('condition', ['new', 'like_new', 'good', 'fair'])->nullable();
            $table->json('specifications')->nullable();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->integer('views_count')->default(0);
            $table->timestamp('featured_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};