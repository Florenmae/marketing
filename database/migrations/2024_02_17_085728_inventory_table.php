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
            $table->id();
            $table->integer('categoryId')->nullable();
            $table->string('productId')->nullable();
            $table->string('productName')->nullable();
            $table->string('userId')->nullable();
            $table->float('price')->nullable();
            $table->string('unit')->nullable();
            $table->float('stocks')->nullable();
            $table->float('qty')->nullable();
            $table->text('description')->nullable();
            $table->string('approved_by'); 
            $table->boolean('status')->default('1'); 
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
