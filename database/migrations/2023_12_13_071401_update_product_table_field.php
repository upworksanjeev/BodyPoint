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
				$table->text('overview')->nullable()->after('description');
				$table->string('video')->nullable()->after('warranty');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('overview');
            $table->dropColumn('video');
        });
        
    }
};
