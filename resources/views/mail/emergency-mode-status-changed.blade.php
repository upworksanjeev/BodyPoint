@php
    $isReminder = $eventType === 'daily_reminder';
    $isAutoDisabled = $eventType === 'auto_disabled';
    $stateLabel = $setting->is_enabled ? 'ENABLED' : 'DISABLED';
@endphp

<p>Emergency Mode status update for Partner Vault.</p>

@if ($isReminder)
    <p><strong>Reminder:</strong> Emergency Mode is still enabled.</p>
@elseif ($isAutoDisabled)
    <p><strong>Status:</strong> AUTO-DISABLED after configured time window.</p>
@else
    <p><strong>Status:</strong> {{ $stateLabel }}</p>
@endif

<p><strong>Banner Message:</strong><br>{{ $setting->banner_message }}</p>

<p><strong>Auto Disable At:</strong> {{ $setting->auto_disable_at?->toDateTimeString() ?? 'Not set' }}</p>
<p><strong>Last Enabled At:</strong> {{ $setting->last_enabled_at?->toDateTimeString() ?? '-' }}</p>
<p><strong>Last Enabled By:</strong> {{ $setting->enabledBy?->email ?? '-' }}</p>
<p><strong>Last Disabled At:</strong> {{ $setting->last_disabled_at?->toDateTimeString() ?? '-' }}</p>
<p><strong>Last Disabled By:</strong> {{ $setting->disabledBy?->email ?? '-' }}</p>
