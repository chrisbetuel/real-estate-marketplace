<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conversation_participants', function (Blueprint $table) {
            // Add last_read_at if it doesn't exist
            if (!Schema::hasColumn('conversation_participants', 'last_read_at')) {
                $table->timestamp('last_read_at')->nullable();
            }
            
            // Ensure foreign keys exist
            $table->foreignId('conversation_id')->change();
            $table->foreignId('user_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('conversation_participants', function (Blueprint $table) {
            $table->dropColumn('last_read_at');
        });
    }
};