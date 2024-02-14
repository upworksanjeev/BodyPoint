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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
			$table->foreignId('cart_id')->constrained();
			$table->foreignId('product_id')->constrained();
			$table->unsignedDecimal('price', $precision = 8, $scale = 2)->nullable();
			$table->unsignedInteger('quantity')->nullable();
			$table->unsignedInteger('discount')->nullable();
			$table->unsignedDecimal('discount_price', $precision = 8, $scale = 2)->nullable();
			$table->timestamps();			
        });
    }
	
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('cart_items');
      
    }
};
