<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function(Blueprint $table){
            $table->id('productId');
            $table->integer('categoryId')->nullable();
            $table->string('item_code')->nullable();
            $table->string('productName')->nullable();
            $table->string('image')->nullable();
            $table->string('supplierId')->nullable();
            $table->float('price')->nullable();
            $table->string('unit')->nullable();
            $table->float('qty')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default('0'); //0 pending 1 accept  2 reject
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
