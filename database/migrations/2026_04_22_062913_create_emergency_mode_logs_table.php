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
        Schema::create('emergency_mode_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergency_mode_setting_id')->constrained('emergency_mode_settings')->cascadeOnDelete();
            $table->string('event_type', 50);
            $table->foreignId('triggered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_mode_logs');
    }
};
