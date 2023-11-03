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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('small_description')->nullable();
			$table->text('description')->nullable();
			$table->text('sizing')->nullable();
			$table->text('instruction_of_use')->nullable();
			$table->text('warranty')->nullable();
			$table->enum('product_type',['Single','Option'])->default('Single');
			$table->enum('is_deleted',['0','1'])->default(0);
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('products');
      
    }
};
