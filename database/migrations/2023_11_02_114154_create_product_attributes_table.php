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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger("prod_id");
            $table->foreign('prod_id')->references('id')->on('attribute_categories');
			$table->unsignedBigInteger("attr_id");
            $table->foreign('attr_id')->references('id')->on('attributes');
			$table->unsignedBigInteger('attr_order');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('product_attributes');
    }
};
