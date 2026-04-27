<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_shop_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_shop_id')->constrained('pos_shops')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['admin', 'manager', 'cashier'])->default('cashier');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['pos_shop_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_shop_user');
    }
};

