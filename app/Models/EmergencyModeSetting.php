<?php

namespace App\Models;

use App\Mail\EmergencyModeStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmergencyModeSetting extends Model
{
    public ?string $transitionEventType = null;

    protected $fillable = [
        'is_enabled',
        'banner_message',
        'auto_disable_hours',
        'auto_disable_at',
        'last_enabled_at',
        'last_enabled_by',
        'last_disabled_at',
        'last_disabled_by',
        'last_reminder_sent_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'auto_disable_at' => 'datetime',
        'last_enabled_at' => 'datetime',
        'last_disabled_at' => 'datetime',
        'last_reminder_sent_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $setting) {
            if (!$setting->isDirty('is_enabled')) {
                return;
            }

            $userId = Auth::id();

            if ($setting->is_enabled) {
                $setting->last_enabled_at = now();
                $setting->last_enabled_by = $userId;
                $setting->last_reminder_sent_at = null;
                $setting->auto_disable_at = !empty($setting->auto_disable_hours)
                    ? now()->addHours((int) $setting->auto_disable_hours)
                    : null;
            } else {
                $setting->last_disabled_at = now();
                $setting->last_disabled_by = $userId;
                $setting->auto_disable_at = null;
                $setting->last_reminder_sent_at = null;
            }
        });

        static::saved(function (self $setting) {
            if (!$setting->wasChanged('is_enabled')) {
                return;
            }

            $eventType = $setting->transitionEventType
                ?: ($setting->is_enabled ? 'toggled_on' : 'toggled_off');

            $setting->logs()->create([
                'event_type' => $eventType,
                'triggered_by' => Auth::id(),
                'meta' => [
                    'is_enabled' => $setting->is_enabled,
                    'banner_message' => $setting->banner_message,
                    'auto_disable_hours' => $setting->auto_disable_hours,
                    'auto_disable_at' => optional($setting->auto_disable_at)->toDateTimeString(),
                ],
            ]);

            $to = config('bodypoint.mail_for_emergency');
            if (!$to) {
                return;
            }

            Mail::to($to)->send(new EmergencyModeStatusChanged(
                $setting,
                $eventType
            ));
        });
    }

    public function enabledBy()
    {
        return $this->belongsTo(User::class, 'last_enabled_by');
    }

    public function disabledBy()
    {
        return $this->belongsTo(User::class, 'last_disabled_by');
    }

    public function logs()
    {
        return $this->hasMany(EmergencyModeLog::class)->latest();
    }

    public function writeLog(string $eventType, ?array $meta = null, ?int $triggeredBy = null): void
    {
        $this->logs()->create([
            'event_type' => $eventType,
            'triggered_by' => $triggeredBy,
            'meta' => $meta,
        ]);
    }

    public static function current(): self
    {
        return self::query()->firstOrCreate(
            ['id' => 1],
            [
                'is_enabled' => false,
                'banner_message' => 'Online ordering is temporarily paused while we resolve a technical issue. To place an order, please email sales@bodypoint.com or call 1-800-547-5716. Thank you for your patience.',
            ]
        );
    }

    public function getBannerMessageHtmlAttribute(): string
    {
        $message = e($this->banner_message);
        $message = str_replace(
            'sales@bodypoint.com',
            '<a href="mailto:sales@bodypoint.com" class="underline font-semibold">sales@bodypoint.com</a>',
            $message
        );
        $message = str_replace(
            '1-800-547-5716',
            '<a href="tel:+18005475716" class="underline font-semibold">1-800-547-5716</a>',
            $message
        );

        return nl2br($message);
    }
}
