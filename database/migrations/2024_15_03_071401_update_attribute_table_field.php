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
		if(Schema::hasTable('attributes')) {
			Schema::table('attributes', function (Blueprint $table) {
				$table->string('image')->nullable()->after('attribute');
				$table->text('small_description')->nullable()->after('image');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('small_description');
        });
        
    }
};
