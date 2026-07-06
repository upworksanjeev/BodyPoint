<?php

namespace App\Mail;

use App\Models\EmergencyModeSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmergencyModeStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public EmergencyModeSetting $setting;

    public string $eventType;

    public function __construct(EmergencyModeSetting $setting, string $eventType)
    {
        $this->setting = $setting;
        $this->eventType = $eventType;
    }

    public function build()
    {
        $subjectMap = [
            'toggled_on' => 'Bodypoint Emergency Mode Activated',
            'toggled_off' => 'Bodypoint Emergency Mode Deactivated',
            'auto_disabled' => 'Bodypoint Emergency Mode Auto-Disabled',
            'daily_reminder' => 'Bodypoint Emergency Mode Daily Reminder',
        ];

        return $this->subject($subjectMap[$this->eventType] ?? 'Bodypoint Emergency Mode Update')
            ->view('mail.emergency-mode-status-changed');
    }
}
