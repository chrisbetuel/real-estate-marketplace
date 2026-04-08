<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_products_table_for_store.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add store_id if doesn't exist
            if (!Schema::hasColumn('products', 'store_id')) {
                $table->foreignId('store_id')->nullable()->constrained()->onDelete('set null');
            }
            
            // Add stock if doesn't exist
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0);
            }
            
            // Add sales_count if doesn't exist
            if (!Schema::hasColumn('products', 'sales_count')) {
                $table->integer('sales_count')->default(0);
            }
            
            // Add price if doesn't exist
            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
            
            // Add category if doesn't exist
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['store_id', 'stock', 'sales_count', 'price', 'category'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};