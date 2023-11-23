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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(\App\Models\Shop::class, 'shop_id');
            $table->foreignIdFor(\App\Models\Category::class, 'category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('barcode')->nullable();
            $table->string('image')->nullable();
            $table->unsignedDecimal('price', 8, 2)->default(1);
            $table->unsignedInteger('weight')->default(1);
            $table->boolean('in_stock')->default(false);
            $table->unsignedDecimal('quantity', 6, 2)->default(1);
            $table->unsignedDecimal('need_quantity', 8, 2)->default(2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
