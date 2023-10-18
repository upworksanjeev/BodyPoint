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
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Country;
use Validator;
use App\Http\Requests\StorePostRequest;


class RegisteredUserController extends Controller
{

    
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::all();
        return view('auth.register' ,compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
       
        $validated = $request->validated();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       
        Auth::login($user);
    
        if($user){

            UserDetails::create([
                "user_id" => $user->id,
                'primary_phone' => $request->primary_phone,
                'alternate_phone' => $request->alternate_phone,
                'customer_number' => $request->customer_number,
                'shipping_user_name' => $request->shipping_user_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zip' => $request->shipping_zip,
                'shipping_country' => $request->shipping_country,
                'shipping_phone' => $request->shipping_phone,
                'billing_user_name' => $request->billing_user_name,
                'billing_last_name' => $request->billing_last_name,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_zip' => $request->billing_zip,
                'billing_country' => $request->billing_country,
                'billing_phone' => $request->billing_phone,

            ] );

            event(new Registered($user));    
            return redirect(RouteServiceProvider::HOME);
        }

    
    
    }



}
