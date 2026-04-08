<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('commission_records')) {
            Schema::create('commission_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('job_id')->constrained('project_jobs')->onDelete('cascade');
                $table->foreignId('professional_id')->constrained('users')->onDelete('cascade');
                $table->decimal('job_amount', 12, 2);
                $table->decimal('commission_percentage', 5, 2);
                $table->decimal('commission_amount', 12, 2);
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_records');
    }
};