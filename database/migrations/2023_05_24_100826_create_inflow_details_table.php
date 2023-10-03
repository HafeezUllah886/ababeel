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
        Schema::create('inflow_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('stock_id');
            $table->unsignedDecimal('price');
            $table->unsignedDecimal('qty');
            $table->unsignedBigInteger('warehouse');
            $table->foreign('bill_id')->references('id')->on('inflows');
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
        Schema::dropIfExists('inflow_details');
    }
};
