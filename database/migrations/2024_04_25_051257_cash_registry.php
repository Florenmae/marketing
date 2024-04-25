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
         Schema::create('cashReg', function (Blueprint $table) {
            $table->id();
            $table->integer('transactionId')->nullable();
            $table->string('CashOnHand')->nullable();
            $table->boolean('type')->nullable();
            $table->float('total')->nullable();
            $table->boolean('paymentMethod')->default('1'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
