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
        Schema::create('outflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to');
            $table->date('date');
            $table->unsignedBigInteger('paidIn')->nullable();
            $table->string('isPaid')->nullable();
            $table->unsignedFloat('discount')->default(0);
            $table->unsignedFloat('amountPaid')->nullable();
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('ref');
            $table->foreign('to')->references('id')->on('accounts');
            $table->foreign('paidIn')->references('id')->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outflows');
    }
};
