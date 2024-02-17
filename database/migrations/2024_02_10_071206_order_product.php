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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id('orderId');
            $table->string('customerId')->nullable();
            $table->string('productId')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->float('price')->nullable();
            $table->float('qty')->nullable();
            $table->float('total')->nullable();
            $table->boolean('paymentMethod')->default('1'); //1 for cash 2 credit
            $table->float('balance')->nullable();
            $table->float('changeAmount')->nullable();
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
