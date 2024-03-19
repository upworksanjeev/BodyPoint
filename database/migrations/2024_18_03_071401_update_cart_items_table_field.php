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
				$table->unsignedDecimal('msrp', $precision = 8, $scale = 2)->nullable()->after('quantity');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('msrp');
        });
        
    }
};
