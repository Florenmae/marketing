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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('trans_id')->nullable();
            $table->string('productId')->nullable();
            $table->string('userId')->nullable();
            $table->boolean('paymentType')->nullable();
            $table->float('qty')->nullable();
            $table->float('stocks')->nullable();
            // $table->string('approved_by')->nullable();
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
