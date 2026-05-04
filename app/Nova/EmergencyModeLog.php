<?php

namespace App\Nova;

use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;

class EmergencyModeLog extends Resource
{
    public static $model = \App\Models\EmergencyModeLog::class;

    public static $title = 'id';

    public static $search = [
        'id',
        'event_type',
    ];

    public static $displayInNavigation = false;

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->readonly(),
            Text::make('Action', function () {
                return match ($this->event_type) {
                    'toggled_on' => 'Emergency Mode Enabled',
                    'toggled_off' => 'Emergency Mode Disabled',
                    'auto_disabled' => 'Emergency Mode Auto-Disabled',
                    'daily_reminder_sent' => 'Daily Reminder Sent',
                    default => ucwords(str_replace('_', ' ', (string) $this->event_type)),
                };
            })->readonly()->sortable(),
            Text::make('Emergency Mode', function () {
                $stateFromMeta = data_get($this->meta, 'is_enabled');
                if (!is_null($stateFromMeta)) {
                    return $stateFromMeta ? 'Enabled' : 'Disabled';
                }

                return match ($this->event_type) {
                    'toggled_on', 'daily_reminder_sent' => 'Enabled',
                    'toggled_off', 'auto_disabled' => 'Disabled',
                    default => '-',
                };
            })->readonly(),
            Text::make('Triggered By', function () {
                $user = $this->triggeredBy;
                if (!$user) {
                    return 'System';
                }

                $name = trim((string) ($user->name ?? ''));
                if ($name === '') {
                    $name = trim((string) (($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
                }

                if ($name === '') {
                    return $user->email ?? ('User #' . $user->id);
                }

                return !empty($user->email) ? $name . ' (' . $user->email . ')' : $name;
            })->readonly(),
            Textarea::make('Meta', function () {
                return $this->meta ? json_encode($this->meta, JSON_PRETTY_PRINT) : '';
            })->readonly()->alwaysShow(),
            DateTime::make('Changed At', 'created_at')->readonly()->sortable(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function authorizedToCreate(\Illuminate\Http\Request $request)
    {
        return false;
    }

    public function authorizedToView(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(\Illuminate\Http\Request $request)
    {
        return false;
    }

    public function authorizedToDelete(\Illuminate\Http\Request $request)
    {
        return false;
    }
}
