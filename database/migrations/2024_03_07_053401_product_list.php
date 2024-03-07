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
        Schema::create('productLists', function (Blueprint $table) {
            $table->id();
            $table->string('categoryId')->nullable();
            $table->string('item_code')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->float('price')->nullable();
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
