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
		if(Schema::hasTable('products')) {
			Schema::table('products', function (Blueprint $table) {
				$table->string('sku')->nullable()->after('id');
				$table->double('msrp', 8, 2)->nullable()->after('product_type');
				$table->double('price', 8, 2)->nullable()->after('msrp');
				$table->double('discount', 8, 2)->nullable()->after('price');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->dropColumn('msrp');
            $table->dropColumn('price');
            $table->dropColumn('discount');
        });
        
    }
};
