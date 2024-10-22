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
        Schema::table('users', function (Blueprint $table) {
            $table->string('default_customer_id')->nullable()->after('name');
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->string('tax_status')->nullable()->after('profile_img');
            $table->string('tax_exemption_no')->nullable()->after('tax_status');
            $table->string('credit_limit')->nullable()->after('tax_exemption_no');
            $table->string('class_id')->nullable()->after('credit_limit');
            $table->string('invoice_term_code')->nullable()->after('class_id');
            $table->string('user_field')->nullable()->after('invoice_term_code');
            $table->string(column: 'salesperson')->nullable()->after('user_field');
            $table->string(column: 'invoice_discount_code')->nullable()->after('salesperson');
            $table->string(column: 'branch')->nullable()->after('invoice_discount_code');
            $table->string(column: 'line_discount_code')->nullable()->after('branch');
            $table->string(column: 'state_code')->nullable()->after('line_discount_code');
            $table->string(column: 'default_email')->nullable()->after('state_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('default_customer_id');
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('tax_status');
            $table->dropColumn('tax_exemption_no');
            $table->dropColumn('credit_limit');
            $table->dropColumn(columns: 'class_id');
            $table->dropColumn('invoice_term_code');
            $table->dropColumn('user_field');
            $table->dropColumn(columns: 'salesperson');
            $table->dropColumn(columns: 'invoice_discount_code');
            $table->dropColumn(columns: 'branch');
            $table->dropColumn(columns: 'line_discount_code');
            $table->dropColumn(columns: 'state_code');
            $table->dropColumn(columns: 'default_email');
        });
    }
};
