<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_shop_id')->constrained('pos_shops')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->timestamps();

            $table->unique(['pos_shop_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_inventories');
    }
};

