<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_shop_id')->constrained('pos_shops')->onDelete('cascade');
            $table->foreignId('to_shop_id')->constrained('pos_shops')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_stock_transfers');
    }
};

