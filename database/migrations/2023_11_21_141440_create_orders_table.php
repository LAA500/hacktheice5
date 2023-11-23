<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(\App\Models\Shop::class, 'shop_id');
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('payment_method')->default('online');
            $table->string('delivery_method')->default('delivery');
            $table->unsignedDecimal('total', 10, 2)->default(0);
            $table->unsignedDecimal('subtotal', 10, 2)->default(0);
            $table->unsignedDecimal('discount')->default(0);
            $table->unsignedDecimal('delivery_cost', 5, 2)->default(0);
            $table->string('address')->nullable();
            $table->unsignedInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
