<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('emergency_mode_settings', function (Blueprint $table) {
            $table->text('notification_emails')->nullable()->after('banner_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emergency_mode_settings', function (Blueprint $table) {
            $table->dropColumn('notification_emails');
        });
    }
};

