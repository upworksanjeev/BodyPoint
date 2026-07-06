<?php

namespace Database\Seeders;

use App\Models\EmergencyModeSetting;
use Illuminate\Database\Seeder;

class EmergencyModeSettingsSeeder extends Seeder
{
    /**
     * Ensures the singleton emergency mode row exists with the same defaults as the
     * create_emergency_mode_settings migration. Safe to run anytime; does not run on migrate.
     *
     * Model events are disabled so seeding does not send notification emails or write toggle logs.
     */
    public function run(): void
    {
        $defaults = [
            'is_enabled' => false,
            'banner_message' => 'Online ordering is temporarily paused while we resolve a technical issue. To place an order, please email sales@bodypoint.com or call 1-800-547-5716. Thank you for your patience.',
            'auto_disable_hours' => null,
            'auto_disable_at' => null,
            'last_enabled_at' => null,
            'last_enabled_by' => null,
            'last_disabled_at' => null,
            'last_disabled_by' => null,
            'last_reminder_sent_at' => null,
        ];

        EmergencyModeSetting::withoutEvents(function () use ($defaults) {
            EmergencyModeSetting::updateOrCreate(
                ['id' => 1],
                $defaults
            );
        });
    }
}
