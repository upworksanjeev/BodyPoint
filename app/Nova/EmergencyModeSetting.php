<?php

namespace App\Nova;

use App\Nova\Actions\DisableEmergencyMode;
use App\Nova\Actions\EnableEmergencyMode;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Email;
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
            ID::make()->sortable()->readonly()->hideFromDetail(),

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
                ->help('This text is displayed in the emergency banner.'),

            Textarea::make('Notification Emails', 'notification_emails')
                ->required(true)
                ->rows(2)
                ->hideFromIndex()
                ->rules(
                    'required',
                    'string',
                    function (string $attribute, mixed $value, \Closure $fail): void {
                        $emails = array_values(array_filter(array_map('trim', explode(',', (string) $value))));
                        if (count($emails) === 0) {
                            $fail('Enter at least one valid notification email address.');

                            return;
                        }
                        foreach ($emails as $email) {
                            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $fail('Invalid notification email: ' . $email);

                                return;
                            }
                        }
                    }
                )
                ->help('Required. Comma-separated addresses for internal alerts when Emergency Mode is toggled and for daily reminders.'),

            Email::make('Send Email Order', 'order_request_email')
                ->required(true)
                ->rules('required', 'email:filter')
                ->hideFromIndex()
                ->help('Required. To: address for partner “Send Email Order” and “Email Order from this Quote” mailto links when emergency mode is on.'),

            Number::make('Auto Disable After (Hours)', 'auto_disable_hours')
                ->min(1)
                ->step(1)
                ->nullable()
                ->hideFromIndex()
                ->help('Optional. When Emergency Mode is enabled, it will automatically turn off after this many hours.'),

            DateTime::make('Auto Disable At (UTC)', 'auto_disable_at')
                ->readonly()
                ->sortable()
                ->exceptOnForms(),
            DateTime::make('Last Enabled At (UTC)', 'last_enabled_at')->readonly()->onlyOnDetail(),
            Text::make('Last Enabled By', function () {
                return $this->enabledBy?->email ?? '-';
            })->readonly()->onlyOnDetail(),
            DateTime::make('Last Disabled At (UTC)', 'last_disabled_at')->readonly()->onlyOnDetail(),
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
