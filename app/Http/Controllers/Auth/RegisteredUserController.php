<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Country;
use App\Http\Requests\StorePostRequest;
use App\Services\SysproService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::all();
        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();


        $url = 'GetCustomerDetails/' . $request->syspro_customer_id;
        $get_customer_details = SysproService::getCustomerDetails($url);
        if (!$get_customer_details) {
            return redirect()->back()->withInput()->withErrors([
                'syspro_customer_id' => 'This Customer Account Number is not registered with partner portal. Please contact Bodypoint Team.',
            ]);
        }


        // Check if email already exists
        $existingUser = User::withTrashed()->where('email', $request->email)->first();

        if ($existingUser) {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $newDeletedEmail = $request->email . "_deleted_" . $timestamp;

            // Ensure email is truly unique
            while (User::where('email', $newDeletedEmail)->exists()) {
                $timestamp = now()->format('Y-m-d_H-i-s') . '_' . rand(1000, 9999);
                $newDeletedEmail = $request->email . "_deleted_" . $timestamp;
            }

            $existingUser->update(['email' => $newDeletedEmail]);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'default_customer_id' => $request->syspro_customer_id,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        if ($user) {

            UserDetails::create([
                "user_id" => $user->id,
                'primary_phone' => '',
                'alternate_phone' => '',
                'customer_number' => $get_customer_details['CustomerAccountNumber'],
                'shipping_user_name' => $get_customer_details['CustomerName'],
                'shipping_last_name' => '',
                'shipping_address' => $get_customer_details['ShipToAddresses'][0]['AddressLine2'] ?? '',
                'shipping_city' => $get_customer_details['ShipToAddresses'][0]['AddressLine4'] ?? '',
                'shipping_state' => $get_customer_details['ShipToAddresses'][0]['State'] ?? '',
                'shipping_zip' => '',
                'shipping_country' => $get_customer_details['ShipToAddresses'][0]['Country'] ?? '',
                'shipping_phone' => '',
                'billing_user_name' => $get_customer_details['CustomerName'],
                'billing_last_name' => '',
                'billing_address' => $get_customer_details['billAddressLine2'] ?? '',
                'billing_city' => $get_customer_details['billAddressLine4'] ?? '',
                'billing_state' => $get_customer_details['billAddressLine5'] ?? '',
                'billing_zip' => $get_customer_details['billAddressPostalCode'] ?? '',
                'billing_country' => '',
                'billing_phone' => '',
            ]);


            session()->put('customer_id', auth()->user()->default_customer_id);
            session()->put('customer_details', $get_customer_details);
            session()->put('customer_address', $get_customer_details['ShipToAddresses'][0]);
            auth()->user()->update([
                'payment_term_description' => $get_customer_details['PaymentTermDescription']
            ]);
            // **Assign Role to User**
            if ($get_customer_details['CustomerClass'] == "") {
                if (!$user->hasRole('Public User')) {
                    $user->assignRole('Public User');
                }
            } else {
                if (!$user->hasRole($get_customer_details['CustomerClass'])) {
                    $user->assignRole($get_customer_details['CustomerClass']);
                }
            }

            // **Check for Associated Customers**
            if (!$user->associateCustomers->isEmpty()) {
                $customer = $user->associateCustomers()->where('customer_id', $request->syspro_customer_id)->first();
                if ($customer && !$customer->hasRole($get_customer_details['CustomerClass'])) {
                    if ($get_customer_details['CustomerClass'] == "") {
                        if (!$customer->hasRole('Public User')) {
                            $customer->assignRole('Public User');
                        }
                    }
                    $customer->assignRole($get_customer_details['CustomerClass']);
                }
            }
            event(new Registered($user));

            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice');
        }
    }
}
