<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_locations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // 'store', 'professional', 'agency'
            $table->string('category')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('place_id')->nullable(); // Google Place ID
            $table->boolean('is_verified')->default(false);
            $table->json('business_hours')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('review_count')->default(0);
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
            
            // Indexes for fast geospatial queries
            $table->index(['latitude', 'longitude']);
            $table->index('type');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};