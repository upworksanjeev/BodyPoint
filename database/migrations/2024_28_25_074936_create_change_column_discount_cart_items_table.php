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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('discount', 8, 2)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('discount', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->integer('discount')->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('discount')->change();
        });
    }
};
