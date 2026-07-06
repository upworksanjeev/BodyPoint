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
        Schema::create('emergency_mode_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(false);
            $table->text('banner_message');
            $table->unsignedInteger('auto_disable_hours')->nullable();
            $table->timestamp('auto_disable_at')->nullable();
            $table->timestamp('last_enabled_at')->nullable();
            $table->foreignId('last_enabled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_disabled_at')->nullable();
            $table->foreignId('last_disabled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_reminder_sent_at')->nullable();
            $table->timestamps();
        });

        DB::table('emergency_mode_settings')->insert([
            'is_enabled' => false,
            'banner_message' => 'Online ordering is temporarily paused while we resolve a technical issue. To place an order, please email sales@bodypoint.com or call 1-800-547-5716. Thank you for your patience.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_mode_settings');
    }
};
