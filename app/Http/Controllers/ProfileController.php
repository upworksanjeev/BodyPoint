<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Country;
use App\Models\UserDetails;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $countries = Country::all();
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
        $customer_id = session()->get('customer_id') ?? $request->user()->default_customer_id;
        $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        $userDetail = $customer ?? $user;
        return view('profile.edit', [
            'user' => $request->user(),
            'countries' => $countries,
            'userDetail' => $userDetail,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
        $customer_id = session()->get('customer_id') ?? $request->user()->default_customer_id;
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
		if($request->has('profile_img')){
			$image=Storage::disk('public')->put('user_profile',$request->file('profile_img'));
		}else{
			$user_detail=UserDetails::where('user_id', $request->user()->id)->first();
			if($user_detail){
				$image=$user_detail->profile_img;
			}
		}
         UserDetails::updateOrCreate(['user_id' =>  $request->user()->id],[
            'profile_img' => $image??'',
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
        ]);
        $user->associateCustomers()->where('customer_id',$customer_id)->update([
            'primary_phone' => $request->primary_phone,
            'alternate_phone' => $request->alternate_phone,
        ]);
        return Redirect::route('profile.edit')->with('success', 'Profile Updated Successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
