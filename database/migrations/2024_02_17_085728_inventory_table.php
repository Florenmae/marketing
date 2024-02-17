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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id('inventoryId');
            $table->string('productId')->nullable();
            $table->string('productName')->nullable();
            $table->string('supplierId')->nullable();
            $table->float('qty')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default('1'); //1 accept 2 reject
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
