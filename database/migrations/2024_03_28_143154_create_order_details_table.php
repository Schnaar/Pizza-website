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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained(
                table: 'orders', indexName: 'order_order_details_id');
            $table->foreignId('pizza_id')->constrained(
                table: 'pizzas', indexName: 'order_details_pizza_id');
            $table->string('size');
            $table->decimal('price', 8, 2); // Example of using decimal data type for price with precision and scale
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};

