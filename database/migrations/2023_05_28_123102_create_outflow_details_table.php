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
        Schema::create('outflow_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('stock_id');
            $table->string('unit');
            $table->unsignedBigInteger('warehouse');
            $table->unsignedDecimal('width', 10, 5);
            $table->unsignedDecimal('length', 10, 5);
            $table->unsignedDecimal('sqf', 10, 5);
            $table->unsignedFloat('price');
            $table->unsignedDecimal('qty');
            $table->foreign('bill_id')->references('id')->on('outflows');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('warehouse')->references('id')->on('warehouses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outflow_details');
    }
};
