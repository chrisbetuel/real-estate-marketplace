<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_transactions_table_for_monetization.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('transactions', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            }
            
            if (!Schema::hasColumn('transactions', 'type')) {
                $table->string('type')->default('deposit');
            }
            
            if (!Schema::hasColumn('transactions', 'amount')) {
                $table->decimal('amount', 12, 2)->default(0);
            }
            
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->string('status')->default('pending');
            }
            
            if (!Schema::hasColumn('transactions', 'description')) {
                $table->text('description')->nullable();
            }
            
            if (!Schema::hasColumn('transactions', 'reference_id')) {
                $table->string('reference_id')->nullable();
            }
            
            if (!Schema::hasColumn('transactions', 'balance_before')) {
                $table->decimal('balance_before', 12, 2)->nullable();
            }
            
            if (!Schema::hasColumn('transactions', 'balance_after')) {
                $table->decimal('balance_after', 12, 2)->nullable();
            }
            
            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->nullable();
            }
            
            if (!Schema::hasColumn('transactions', 'stripe_payment_intent')) {
                $table->string('stripe_payment_intent')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $columns = ['user_id', 'type', 'amount', 'status', 'description', 
                        'reference_id', 'balance_before', 'balance_after', 
                        'payment_method', 'stripe_payment_intent'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};