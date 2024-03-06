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
        Schema::create('deliveryCarts', function (Blueprint $table) {
            $table->id();
            $table->string('deliveryId')->nullable();
            $table->string('productId')->nullable();
            $table->float('qty')->nullable();
            $table->float('price')->nullable();
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
