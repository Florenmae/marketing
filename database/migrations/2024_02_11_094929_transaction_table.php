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
            $table->integer('productlistId')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('roleId')->nullable();
            $table->boolean('type')->nullable();
            $table->float('qty')->nullable();
            $table->float('actualQty')->nullable();
            $table->float('stocks')->nullable();
            $table->float('totalprice')->nullable();
            $table->float('amountGiven')->nullable();
            $table->float('changeAmount')->nullable();
            $table->float('balance')->nullable();
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
