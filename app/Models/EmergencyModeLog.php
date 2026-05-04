<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyModeLog extends Model
{
    protected $fillable = [
        'emergency_mode_setting_id',
        'event_type',
        'triggered_by',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function setting()
    {
        return $this->belongsTo(EmergencyModeSetting::class, 'emergency_mode_setting_id');
    }

    public function triggeredBy()
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }
}
