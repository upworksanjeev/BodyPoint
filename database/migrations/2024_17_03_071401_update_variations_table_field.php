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
		if(Schema::hasTable('variations')) {
			Schema::table('variations', function (Blueprint $table) {
				$table->unsignedDecimal('msrp', $precision = 8, $scale = 2)->nullable()->after('sku');
				$table->double('discount', 8, 2)->nullable()->after('price');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('variations', function (Blueprint $table) {
            $table->dropColumn('msrp');
            $table->dropColumn('discount');
        });
        
    }
};
