<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Partner mailto “To:” for emergency Send Email Order / quote flows — set in Nova (required on save).
     */
    public function up(): void
    {
        if (Schema::hasColumn('emergency_mode_settings', 'order_request_email')) {
            return;
        }

        Schema::table('emergency_mode_settings', function (Blueprint $table) {
            $table->string('order_request_email', 255)
                ->nullable()
                ->after('notification_emails');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('emergency_mode_settings', 'order_request_email')) {
            return;
        }

        Schema::table('emergency_mode_settings', function (Blueprint $table) {
            $table->dropColumn('order_request_email');
        });
    }
};
