<?php

namespace App\Nova;

use App\Nova\Actions\DisableEmergencyMode;
use App\Nova\Actions\EnableEmergencyMode;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class EmergencyModeSetting extends Resource
{
    public static $model = \App\Models\EmergencyModeSetting::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $displayInNavigation = true;
    public static $clickAction = 'edit';

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->readonly(),

            Text::make('Status', function () {
                return $this->is_enabled ? 'Enabled' : 'Disabled';
            })->sortable()->readonly()->exceptOnForms(),

            Text::make('Current Status', function () {
                return $this->is_enabled ? 'Enabled' : 'Disabled';
            })->readonly()->onlyOnForms(),

            Boolean::make('Emergency Mode Enabled', 'is_enabled')
                ->hideFromIndex()
                ->help('Toggle this to enable or disable emergency mode.'),

            Text::make('Banner Message', function () {
                return Str::limit($this->banner_message, 100);
            })->readonly()->onlyOnIndex(),

            Textarea::make('Banner Message', 'banner_message')
                ->rows(4)
                ->rules('required', 'string')
                ->hideFromIndex()
                ->help('This copy is displayed in the emergency banner and can be updated without code changes.'),

            Number::make('Auto Disable After (Hours)', 'auto_disable_hours')
                ->min(1)
                ->step(1)
                ->nullable()
                ->hideFromIndex()
                ->help('Optional. When Emergency Mode is enabled, it will automatically turn off after this many hours.'),

            DateTime::make('Auto Disable At', 'auto_disable_at')->readonly()->onlyOnDetail(),
            DateTime::make('Last Enabled At', 'last_enabled_at')->readonly()->onlyOnDetail(),
            Text::make('Last Enabled By', function () {
                return $this->enabledBy?->email ?? '-';
            })->readonly()->onlyOnDetail(),
            DateTime::make('Last Disabled At', 'last_disabled_at')->readonly()->onlyOnDetail(),
            Text::make('Last Disabled By', function () {
                return $this->disabledBy?->email ?? '-';
            })->readonly()->onlyOnDetail(),

            HasMany::make('Logs', 'logs', EmergencyModeLog::class),
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
        return [
            (new EnableEmergencyMode())->showOnTableRow()->showOnDetail(),
            (new DisableEmergencyMode())->showOnTableRow()->showOnDetail(),
        ];
    }

    public static function authorizedToCreate(\Illuminate\Http\Request $request)
    {
        return false;
    }

    public function authorizedToDelete(\Illuminate\Http\Request $request)
    {
        return false;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('id', 1);
    }

    public function authorizedToUpdate(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        return $user->isSuperAdmin() || $user->isAdmin();
    }
}
