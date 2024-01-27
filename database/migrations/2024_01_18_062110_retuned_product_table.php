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
<<<<<<< HEAD
        Schema::create('returned_products', function(Blueprint $table){
            $table->id();
            $table->string('name');
=======
        Schema::create('returned_Products', function(Blueprint $table){
            $table->id();
            $table->string('name')->nullable();
>>>>>>> 56326e53543457e0ddd35690d4b2a3ea39d8ac5b
            $table->string('item_code');
            $table->string('supplier');
            $table->integer('qty');
            $table->text('description');
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
