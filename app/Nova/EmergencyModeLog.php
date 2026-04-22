<?php

namespace App\Nova;

use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            Text::make('Event Type', 'event_type')->readonly()->sortable(),
            Text::make('Triggered By', function () {
                return $this->triggeredBy?->email ?? 'System';
            })->readonly(),
            Textarea::make('Meta', function () {
                return $this->meta ? json_encode($this->meta, JSON_PRETTY_PRINT) : '';
            })->readonly()->alwaysShow(),
            DateTime::make('Created At', 'created_at')->readonly()->sortable(),
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

    public function authorizedToUpdate(\Illuminate\Http\Request $request)
    {
        return false;
    }

    public function authorizedToDelete(\Illuminate\Http\Request $request)
    {
        return false;
    }
}
