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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger("associate_customer_id")->nullable()->after('user_id');
            $table->foreign('associate_customer_id')->references('id')->on('associate_customers');
            $table->string('customer_number')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['associate_customer_id']);
            $table->dropColumn('associate_customer_id');
            $table->dropColumn('customer_number');
        });
    }
};
