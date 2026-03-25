<?php
// database/migrations/2024_01_01_000002_create_professional_profiles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('professional_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profession'); // engineer, designer, worker, etc.
            $table->text('bio')->nullable();
            $table->integer('years_experience')->nullable();
            $table->json('qualifications')->nullable();
            $table->json('certifications')->nullable();
            $table->json('languages')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->boolean('availability')->default(true);
            $table->json('location_coordinates')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('professional_profiles');
    }
};