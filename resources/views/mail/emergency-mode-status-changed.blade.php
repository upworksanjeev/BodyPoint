@php
    $isEnabledState = (bool) $setting->is_enabled;
    $statusText = $isEnabledState ? 'Activated' : 'Deactivated';

    $formatUser = function ($user) {
        if (!$user) {
            return '-';
        }

        $name = trim((string) ($user->name ?? ''));
        if ($name === '') {
            $name = trim((string) (($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
        }

        $email = trim((string) ($user->email ?? ''));
        if ($name !== '' && $email !== '') {
            return $name . ' (' . $email . ')';
        }

        return $name !== '' ? $name : ($email !== '' ? $email : '-');
    };
@endphp

<div style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.55;">
    <p style="margin: 0 0 14px;">Hi Team,</p>

    @if($isEnabledState)
        <p style="margin: 0 0 14px;">
            Bodypoint Emergency Mode was <strong>Activated</strong> just now and the banner message is showing on required pages.
        </p>
    @else
        <p style="margin: 0 0 14px;">
            Bodypoint Emergency Mode was <strong>Deactivated</strong> just now and the banner has been removed from required pages.
        </p>
    @endif

    <p style="margin: 0 0 10px;">Here are the details:</p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse; width: 100%; max-width: 760px;">
        <tr>
            <td style="width: 220px; font-weight: 700;">Current Emergency State</td>
            <td>{{ $isEnabledState ? 'Enabled' : 'Disabled' }}</td>
        </tr>

        @if($isEnabledState)
            <tr>
                <td style="font-weight: 700;">Banner Message</td>
                <td>{{ $setting->banner_message }}</td>
            </tr>
            <tr>
                <td style="font-weight: 700;">Enabled At</td>
                <td>{{ $setting->last_enabled_at?->toDateTimeString() ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: 700;">Enabled By</td>
                <td>{{ $formatUser($setting->enabledBy) }}</td>
            </tr>
        @else
            <tr>
                <td style="font-weight: 700;">Disabled At</td>
                <td>{{ $setting->last_disabled_at?->toDateTimeString() ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: 700;">Disabled By</td>
                <td>{{ $formatUser($setting->disabledBy) }}</td>
            </tr>
        @endif
    </table>

    <p style="margin: 16px 0 0;">Thanks,</p>
</div>
