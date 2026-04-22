<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DisableEmergencyMode extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Disable Emergency Mode';

    public function __construct()
    {
        $this->confirmText('This will disable emergency mode and send notification email. Continue?');
        $this->confirmButtonText('Disable');
        $this->cancelButtonText('Cancel');
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $setting) {
            if (!$setting->is_enabled) {
                return Action::danger('Emergency Mode is already disabled.');
            }

            $setting->transitionEventType = 'toggled_off';
            $setting->is_enabled = false;
            $setting->save();
        }

        return Action::message('Emergency Mode disabled successfully.');
    }

    public function authorizedToRun($request, $model)
    {
        $user = $request->user();
        $isAllowedRole = $user && ($user->isSuperAdmin() || $user->isAdmin());
        return $isAllowedRole && $model->is_enabled;
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}
