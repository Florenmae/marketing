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
        Schema::create('returned_Products', function(Blueprint $table){
            $table->id();
            $table->integer('productId')->nullable();
            $table->integer('productlistId')->nullable();
            $table->string('item_code')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('returnedBy')->nullable();
            $table->float('qty')->nullable();
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
