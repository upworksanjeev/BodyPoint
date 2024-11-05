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
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('account_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('customeronhold');
            $table->dropColumn('telephone');
            $table->dropColumn('contact');
            $table->dropColumn('last_login_date');
            $table->dropColumn('shipping_code');
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn(columns: 'pricecode_id');
            $table->dropColumn('company_name');
            $table->dropColumn('tax_status');
            $table->dropColumn('tax_exemption_no');
            $table->dropColumn('credit_limit');
            $table->dropColumn('class_id');
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('account_id')->nullable()->after('last_name');
            $table->string('customer_id')->nullable()->after('default_customer_id');
            $table->string('customeronhold')->nullable()->after('account_id');
            $table->string('telephone')->nullable()->after('customeronhold');
            $table->string('contact')->nullable()->after('telephone');
            $table->string('last_login_date')->nullable()->after('contact');
            $table->string('shipping_code')->nullable()->after('last_login_date');
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->string(column: 'pricecode_id')->after('profile_img');
            $table->string('company_name')->after('pricecode_id');
            $table->string('tax_status')->nullable()->after('company_name');
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
};
