<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Add conversation_id if it doesn't exist
            if (!Schema::hasColumn('messages', 'conversation_id')) {
                $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            }
            
            // Add user_id if it doesn't exist
            if (!Schema::hasColumn('messages', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            
            // Add message if it doesn't exist
            if (!Schema::hasColumn('messages', 'message')) {
                $table->text('message');
            }
            
            // Add is_read if it doesn't exist
            if (!Schema::hasColumn('messages', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $columns = ['conversation_id', 'user_id', 'message', 'is_read'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('messages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};