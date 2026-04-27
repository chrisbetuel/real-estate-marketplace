<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_sale_id')->constrained('pos_sales')->onDelete('cascade');
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->decimal('unit_price', 12, 2);
            $table->integer('quantity');
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_sale_items');
    }
};

