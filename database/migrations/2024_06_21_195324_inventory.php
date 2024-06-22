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
        Schema::create('inventories', function(Blueprint $table){
            $table->id();
            $table->integer('productId')->nullable();
            $table->integer('productlistId')->nullable();
            $table->integer('categoryId')->nullable();
            $table->integer('userId')->nullable();
            $table->string('item_code')->nullable();
            $table->string('image')->nullable();
            $table->string('unit')->nullable();
            $table->float('stocks')->nullable();
            $table->text('description')->nullable();
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
