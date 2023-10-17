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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'primary_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'alternate_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'shipping_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'billing_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'shipping_zip' => 'required|regex:/\b\d{5}\b/',
            'billing_zip' => 'required|regex:/\b\d{5}\b/'
            
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        

       
        Auth::login($user);
        

        if($user){

            UserDetails::create([
                "user_id" => $user->id,
                'primary_phone' => $request->input('primary_phone'),
                'alternate_phone' => $request->input('alternate_phone'),
                'customer_number' => $request->input('customer_number'),
                'shipping_user_name' => $request->input('shipping_user_name'),
                'shipping_last_name' => $request->input('shipping_last_name'),
                'shipping_address' => $request->input('shipping_address'),
                'shipping_city' => $request->input('shipping_city'),
                'shipping_state' => $request->input('shipping_state'),
                'shipping_zip' => $request->input('shipping_zip'),
                'shipping_country' => $request->input('shipping_country'),
                'shipping_phone' => $request->input('shipping_phone'),
                'billing_user_name' => $request->input('billing_user_name'),
                'billing_last_name' => $request->input('billing_last_name'),
                'billing_address' => $request->input('billing_address'),
                'billing_city' => $request->input('billing_city'),
                'billing_state' => $request->input('billing_state'),
                'billing_zip' => $request->input('billing_zip'),
                'billing_country' => $request->input('billing_country'),
                'billing_phone' => $request->input('billing_phone'),

            ] );

            event(new Registered($user));    
            return redirect(RouteServiceProvider::HOME);
        }

    
    
    }



}
