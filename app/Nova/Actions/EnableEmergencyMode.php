<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class EnableEmergencyMode extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Enable Emergency Mode';

    public function __construct()
    {
        $this->confirmText('This will enable emergency mode and send notification email. Continue?');
        $this->confirmButtonText('Enable');
        $this->cancelButtonText('Cancel');
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $setting) {
            if ($setting->is_enabled) {
                return Action::danger('Emergency Mode is already enabled.');
            }

            $setting->transitionEventType = 'toggled_on';
            $setting->is_enabled = true;
            $setting->save();
        }

        return Action::message('Emergency Mode enabled successfully.');
    }

    public function authorizedToRun($request, $model)
    {
        return !$model->is_enabled;
    }

    public function canSee(NovaRequest $request)
    {
        return true;
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}
