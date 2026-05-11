<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('keyword', 255)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['keyword']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_alerts');
    }
};

