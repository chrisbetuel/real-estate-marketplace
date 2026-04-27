<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->string('delivery_type')->nullable(); // bajaji, car, etc.
            $table->decimal('delivery_price', 8, 2)->nullable()->default(0);
            $table->enum('delivery_status', ['pending', 'assigned', 'picked_up', 'in_transit', 'delivered', 'cancelled'])->nullable();
            $table->timestamp('delivery_eta')->nullable();
            $table->json('delivery_route')->nullable();

            $table->index('driver_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn([
                'driver_id',
                'delivery_type',
                'delivery_price',
                'delivery_status',
                'delivery_eta',
                'delivery_route'
            ]);
        });
    }
};

