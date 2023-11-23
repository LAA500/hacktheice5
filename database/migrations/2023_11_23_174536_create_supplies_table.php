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
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(\App\Models\Shop::class, 'shop_id')->nullable();
            $table->string('number');
            $table->unsignedDecimal('total')->default(0);
            $table->unsignedDecimal('weight')->default(0);
            $table->foreignIdFor(\App\Models\Warehouse::class, 'from_warehouse_id')->nullable();
            $table->foreignIdFor(\App\Models\Warehouse::class, 'to_warehouse_id')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
