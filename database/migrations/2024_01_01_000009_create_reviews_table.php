<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_job_id')->nullable()->constrained('project_jobs');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('reviewer_id')->constrained('users');
            $table->foreignId('reviewee_id')->constrained('users');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->json('criteria_ratings')->nullable();
            $table->text('response')->nullable();
            $table->timestamp('response_at')->nullable();
            $table->timestamps();
            
            // Ensure one review per job/product per user
            $table->unique(['project_job_id', 'reviewer_id'], 'review_job_unique');
            $table->unique(['product_id', 'reviewer_id'], 'review_product_unique');
            
            $table->index(['reviewee_id', 'rating']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};