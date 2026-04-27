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
        if (Schema::hasTable('escrow_holds')) {
            Schema::table('escrow_holds', function (Blueprint $table) {
                if (!Schema::hasColumn('escrow_holds', 'order_id')) {
                    $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
                }
                if (!Schema::hasColumn('escrow_holds', 'store_id')) {
                    $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        if (Schema::hasTable('escrow_holds')) {
            Schema::table('escrow_holds', function (Blueprint $table) {
                if (Schema::hasColumn('escrow_holds', 'order_id')) {
                    $table->dropForeign(['order_id']);
                    $table->dropColumn('order_id');
                }
                if (Schema::hasColumn('escrow_holds', 'store_id')) {
                    $table->dropForeign(['store_id']);
                    $table->dropColumn('store_id');
                }
            });
        }
    }
};
