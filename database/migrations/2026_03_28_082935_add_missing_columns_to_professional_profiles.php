<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_missing_columns_to_professional_profiles.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            // Add skills column if it doesn't exist
            if (!Schema::hasColumn('professional_profiles', 'skills')) {
                $table->json('skills')->nullable();
            }
            
            // Add stage column if it doesn't exist
            if (!Schema::hasColumn('professional_profiles', 'stage')) {
                $table->tinyInteger('stage')->nullable()->comment('1-9: Service ecosystem stages');
            }
            
            // Add subcategory column if it doesn't exist
            if (!Schema::hasColumn('professional_profiles', 'subcategory')) {
                $table->string('subcategory')->nullable();
            }
            
            // Add certifications column if it doesn't exist
            if (!Schema::hasColumn('professional_profiles', 'certifications')) {
                $table->json('certifications')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $columns = ['skills', 'stage', 'subcategory', 'certifications'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('professional_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};