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
		if(Schema::hasTable('user_details')) {
			Schema::table('user_details', function (Blueprint $table) {
				$table->string('profile_img')->nullable()->after('user_id');
			});
		}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		 Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        
    }
};
