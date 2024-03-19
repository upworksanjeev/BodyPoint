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
		if(Schema::hasTable('order_items')) {
			Schema::table('order_items', function (Blueprint $table) {
				$table->unsignedDecimal('msrp', $precision = 8, $scale = 2)->nullable()->after('marked_for');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('msrp');
        });
        
    }
};
