<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_bids_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_job_id')->constrained('project_jobs')->onDelete('cascade');
            $table->foreignId('professional_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->integer('estimated_days')->nullable();
            $table->text('proposal');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('escrow_id')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};