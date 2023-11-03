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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger("att_cat_id");
            $table->foreign('att_cat_id')->references('id')->on('attribute_categories');
			$table->string('attribute');
			$table->string('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       		Schema::dropIfExists('attributes');
    }
};
