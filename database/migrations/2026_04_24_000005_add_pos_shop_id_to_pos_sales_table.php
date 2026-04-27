<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pos_sales', function (Blueprint $table) {
            $table->foreignId('pos_shop_id')->nullable()->after('user_id')->constrained('pos_shops')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pos_sales', function (Blueprint $table) {
            $table->dropForeign(['pos_shop_id']);
            $table->dropColumn('pos_shop_id');
        });
    }
};

