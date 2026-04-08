<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_stage_to_professional_profiles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('professional_profiles', 'stage')) {
                $table->tinyInteger('stage')->nullable()->comment('1-9: Service ecosystem stages');
            }
            
            if (!Schema::hasColumn('professional_profiles', 'subcategory')) {
                $table->string('subcategory')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->dropColumn(['stage', 'subcategory']);
        });
    }
};