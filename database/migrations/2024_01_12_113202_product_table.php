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
            $table->id();
            $table->integer('categoryId')->nullable();
            $table->string('userId')->nullable();
            $table->string('item_code')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            // $table->float('price')->nullable();
            // $table->string('unit')->nullable();
            // $table->float('stocks')->nullable();
            // $table->text('description')->nullable();
            $table->boolean('status')->default('1'); 
            //$table->string('approved_by'); 
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
