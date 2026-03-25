<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_job_id')->nullable()->constrained('project_jobs');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('professional_id')->constrained('users');
            $table->decimal('amount', 10, 2);
            $table->decimal('platform_fee', 10, 2)->default(0);
            $table->decimal('professional_amount', 10, 2);
            $table->enum('status', ['pending', 'held', 'released', 'refunded', 'disputed'])->default('pending');
            $table->string('payment_method');
            $table->string('transaction_reference')->unique();
            $table->json('payment_details')->nullable();
            $table->timestamp('held_until')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
            
            $table->index(['client_id', 'status']);
            $table->index(['professional_id', 'status']);
            $table->index('transaction_reference');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};