<?php

namespace App\Nova\Actions;

use App\Models\AssociateCustomer;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Actions\Action;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;

class AddAssociateCustomer extends Action
{
    use InteractsWithQueue, Queueable;

    public function authorizedToRun(Request $request, $model)
    {
       
        return true;
    }
    public function showOnDetail()
    {
        return true;
    }
    
    public function name()
    {
        return 'Attach Associate Customer';
    }

    public function handle(ActionFields $fields, $models)
    {
        foreach ($models as $user) {
            \Log::info("Checking for existing associate customer:", [
                'user_id' => $user->id,
                'customer_id' => $fields->customer_id
            ]);
    
            // Check if the customer is already associated with this user
            $existingCustomer = AssociateCustomer::where('user_id', $user->id)
                ->where('customer_id', $fields->customer_id)
                ->first();
    
            if ($existingCustomer) {
                \Log::warning("Duplicate customer detected for user:", [
                    'user_id' => $user->id,
                    'customer_id' => $fields->customer_id
                ]);
                return Action::danger('This customer is already attached to the user.');
            }

            AssociateCustomer::create([
                'user_id' => $user->id, // Ensure this field exists in the model
                'customer_id' => $fields->customer_id, // Ensure this exists in the AssociateCustomer model
                'customer_name' => $fields->customer_name,
                'first_name' => $fields->first_name,
                'last_name' => $fields->last_name,
            ]);
        }

        return Action::message('Customer added successfully!');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Customer ID', 'customer_id')
                ->rules('required', 'integer', 'min:1'),

            Text::make('Customer Name', 'name')
                ->rules('required', 'max:255'),

            Text::make('First Name', 'first_name')
                ->rules('required', 'max:255'),

            Text::make('Last Name', 'last_name')
                ->rules('required', 'max:255'),
        ];
    }



}
