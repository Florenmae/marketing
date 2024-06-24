<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('transactionId')->nullable();
            $table->integer(' userId')->nullable();
            $table->integer('productId')->nullable();
            $table->integer('productlistId')->nullable();
            $table->string('image')->nullable();
            $table->float('qty')->nullable();
            $table->float('price')->nullable();
            $table->float('total')->nullable();
            $table->boolean('paymentMethod')->default('1'); 
            $table->float('balance')->nullable();
            $table->float('changeAmount')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
};
