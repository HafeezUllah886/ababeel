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
            $table->string('code');
            $table->string('color');
            $table->string('unit');
            $table->unsignedDecimal('length', 10, 3);
            $table->unsignedDecimal('width', 10, 3);
            $table->unsignedDecimal('sqf', 8, 3);
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('purchase_price')->nullable();
            $table->unsignedBigInteger('sqf_price')->nullable();
            $table->string('img');
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
