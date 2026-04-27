<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('sale_number')->unique();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('payment_method')->default('cash');
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('change_due', 12, 2)->default(0);
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'completed', 'refunded', 'cancelled'])->default('completed');
            $table->timestamp('sale_date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_sales');
    }
};

