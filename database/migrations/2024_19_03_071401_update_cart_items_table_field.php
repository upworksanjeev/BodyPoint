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
		if(Schema::hasTable('cart_items')) {
			Schema::table('cart_items', function (Blueprint $table) {
				$table->string('sku')->nullable()->after('product_id');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('sku');
        });
        
    }
};
