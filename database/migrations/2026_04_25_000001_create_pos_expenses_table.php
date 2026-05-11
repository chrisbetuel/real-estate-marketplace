<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pos_shop_id')->nullable()->constrained('pos_shops')->onDelete('cascade');
            $table->string('expense_number')->unique();
            $table->string('category');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('payment_method')->default('cash');
            $table->string('receipt_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'expense_date']);
            $table->index(['pos_shop_id', 'expense_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_expenses');
    }
};

