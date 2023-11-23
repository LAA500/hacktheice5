<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Order::class, 'order_id');
            $table->foreignIdFor(\App\Models\Product::class, 'product_id');
            $table->unsignedDecimal('price', 8, 2)->default(0);
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedDecimal('total', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
