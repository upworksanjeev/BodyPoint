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
        Schema::create('associate_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('customer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('account_id')->nullable();
            $table->string('telephone')->nullable();
            $table->string('contact')->nullable();
            $table->string('last_login_date')->nullable();
            $table->string('shipping_code')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tax_status')->nullable();
            $table->string('tax_exemption_no')->nullable();
            $table->string('class_id')->nullable();
            $table->string('user_field')->nullable();
            $table->string(column: 'salesperson')->nullable();
            $table->string(column: 'invoice_discount_code')->nullable();
            $table->string(column: 'branch')->nullable();
            $table->string(column: 'state_code')->nullable();
            $table->string(column: 'default_email')->nullable();
            $table->string(column: 'unit')->nullable();
            $table->string(column: 'street_address')->nullable();
            $table->string(column: 'city')->nullable();
            $table->string(column: 'state')->nullable();
            $table->string(column: 'country')->nullable();
            $table->string(column: 'zip_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associate_customers');
    }
};
