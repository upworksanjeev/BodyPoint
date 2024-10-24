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
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('account_id')->nullable()->after('last_name');
            $table->string('customeronhold')->nullable()->after('account_id');
            $table->string('telephone')->nullable()->after('customeronhold');
            $table->string('contact')->nullable()->after('telephone');
            $table->string('last_login_date')->nullable()->after('contact');
            $table->string('shipping_code')->nullable()->after('last_login_date');
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->string('pricecode_id')->nullable()->after('profile_img');
            $table->string('company_name')->nullable()->after('pricecode_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('account_id');
            $table->dropColumn('customeronhold');
            $table->dropColumn('telephone');
            $table->dropColumn('contact');
            $table->dropColumn('last_login_date');
            $table->dropColumn('shipping_code');
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('pricecode_id');
            $table->dropColumn('company_name');
        });
    }
};
