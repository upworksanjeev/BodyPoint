<?php

namespace App\Console\Commands;

use App\Mail\EmergencyModeStatusChanged;
use App\Models\EmergencyModeSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessEmergencyModeState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emergency-mode:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process emergency mode auto-disable and reminder emails.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $setting = EmergencyModeSetting::current();
        if (!$setting->is_enabled) {
            return self::SUCCESS;
        }

        $recipient = config('bodypoint.mail_for_emergency');
        if (!$recipient) {
            return self::SUCCESS;
        }

        if ($setting->auto_disable_at && now()->greaterThanOrEqualTo($setting->auto_disable_at)) {
            $setting->transitionEventType = 'auto_disabled';
            $setting->is_enabled = false;
            $setting->save();
            return self::SUCCESS;
        }

        if (!$setting->last_reminder_sent_at || $setting->last_reminder_sent_at->lt(now()->subDay())) {
            Mail::to($recipient)->send(new EmergencyModeStatusChanged($setting, 'daily_reminder'));
            $setting->writeLog('daily_reminder_sent', [
                'recipient' => $recipient,
                'is_enabled' => $setting->is_enabled,
            ]);
            $setting->forceFill([
                'last_reminder_sent_at' => now(),
            ])->saveQuietly();
        }

        return self::SUCCESS;
    }
}
