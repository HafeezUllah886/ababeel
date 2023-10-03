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
        Schema::create('inflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from');
            $table->date('date');
            $table->unsignedBigInteger('paidFrom')->nullable();
            $table->string('isPaid');
            $table->string('status');
            $table->unsignedBigInteger('ref');
            $table->foreign('from')->references('id')->on('accounts');
            $table->foreign('paidFrom')->references('id')->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inflows');
    }
};
