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
        Schema::table('escrow_holds', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        Schema::table('escrow_holds', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['store_id']);
            $table->dropColumn(['order_id', 'store_id']);
        });
    }
};
