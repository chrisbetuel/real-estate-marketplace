<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->enum('vehicle_type', ['bajaji', 'three_wheel', 'car', 'motorcycle']);
            $table->boolean('is_available')->default(false);
            $table->decimal('current_lat', 10, 8)->nullable();
            $table->decimal('current_lng', 11, 8)->nullable();
            $table->decimal('price_per_km', 8, 2);
            $table->enum('status', ['online', 'busy', 'offline'])->default('offline');
            $table->timestamps();
            
            $table->index(['store_id', 'is_available', 'status']);
            $table->index(['current_lat', 'current_lng']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};

