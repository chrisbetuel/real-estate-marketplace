<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('listings', 'title')) {
                $table->string('title')->nullable();
            }
            
            if (!Schema::hasColumn('listings', 'description')) {
                $table->text('description')->nullable();
            }
            
            if (!Schema::hasColumn('listings', 'category')) {
                $table->string('category')->nullable();
            }
            
            if (!Schema::hasColumn('listings', 'budget_min')) {
                $table->decimal('budget_min', 10, 2)->nullable();
            }
            
            if (!Schema::hasColumn('listings', 'budget_max')) {
                $table->decimal('budget_max', 10, 2)->nullable();
            }
            
            if (!Schema::hasColumn('listings', 'location')) {
                $table->string('location')->nullable();
            }
            
            if (!Schema::hasColumn('listings', 'status')) {
                $table->string('status')->default('open');
            }
            
            if (!Schema::hasColumn('listings', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $columns = ['title', 'description', 'category', 'budget_min', 
                        'budget_max', 'location', 'status', 'user_id'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('listings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};