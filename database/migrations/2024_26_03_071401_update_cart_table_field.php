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
		if(Schema::hasTable('carts')) {
			Schema::table('carts', function (Blueprint $table) {
				$table->string('purchase_order_no')->nullable()->after('total_items');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('purchase_order_no');
        });
    }
};
