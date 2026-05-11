<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column already exists
        $columns = DB::select('SHOW COLUMNS FROM conversations');
        $columnNames = array_column($columns, 'Field');

        if (!in_array('store_id', $columnNames)) {
            Schema::table('conversations', function (Blueprint $table) {
                $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('cascade');
                $table->index('store_id');
            });
        }
    }

    public function down(): void
    {
        // No rollback needed - column may already exist from earlier migrations
    }
};
