<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\SysproService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        session()->flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function store(LoginRequest $request)
    {
        try{
            $user = User::where('email', $request->email)->first();

            if ($user && !empty($user->default_customer_id)) {
                    $url = 'GetCustomerDetails/' . $user->default_customer_id;
                    $get_customer_details = SysproService::getCustomerDetails($url);
                    
                if (!$get_customer_details) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "If you're having trouble logging in, please reach out to our customer service team for any quote/order requests. Thank you for your patience as we troubleshoot errors on our new website!",
                    ]);
                }

                
                if (empty($user->password)) {
                    $status = Password::sendResetLink(
                        $request->only('email')
                    );
                    if($status == Password::RESET_LINK_SENT){
                        return response()->json([
                            'status' => 'mail_sent',
                            'message' => 'We have sent you an email with password reset link. Please click on the link to reset your password.',
                        ]);
                    }else{
                        return response()->json([
                            'status' => 'throttled',
                            'message' => 'Too many reset attempts. Please try again in a few minutes.',
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => 'exists',
                        'message' => 'User exists. Please enter your password.',
                    ]);
                }
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Customer Does not exist on Syspro',
                ]);
            }
        }
        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Account not found. Please contact Bodypoint Team'
            ]);
        }
    }

    public function checkPassword(CheckPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->with(['associateCustomers'])->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if (!$user->hasVerifiedEmail()) {
                return response()->json([
                    'status' => 'unverified',
                    'message' => 'Your email is not verified. Please check your inbox and verify your email.',
                    'redirect' => route('verification.notice'),
                ]);
            }
            if (!empty(auth()->user()->default_customer_id)) {
                $url = 'GetCustomerDetails/' . auth()->user()->default_customer_id;
                $get_customer_details = SysproService::getCustomerDetails($url);
                if (!empty($get_customer_details)) {
                    if ($get_customer_details['CustomerClass'] == "") {
                        Auth::logout();
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Please Contact BodyPoint for Login Details!',
                        ]);
                    }
                    session()->put('customer_id', auth()->user()->default_customer_id);
                    session()->put('customer_details', $get_customer_details);
                    session()->put('customer_address', $get_customer_details['ShipToAddresses'][0]);
                    auth()->user()->update([
                        'payment_term_description' => $get_customer_details['PaymentTermDescription']
                    ]);
                    if($user->associateCustomers->isEmpty()){
                        if($get_customer_details['CustomerClass'] == ""){
                            if (!$user->hasRole('Public User')) {
                                $user->assignRole('Public User');
                            }
                        }
                        if(!$user->hasRole($get_customer_details['CustomerClass'])){
                            $user->assignRole($get_customer_details['CustomerClass']);
                        }
                    }else{
                        $customer = $user->associateCustomers()->where('customer_id', auth()->user()->default_customer_id)->first();
                        if (!$customer->hasRole($get_customer_details['CustomerClass'])) {
                            if($get_customer_details['CustomerClass'] == ""){
                                if (!$customer->hasRole('Public User')) {
                                    $customer->assignRole('Public User');
                                }
                            }
                            $customer->assignRole($get_customer_details['CustomerClass']);
                        }
                    }
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful!',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect Credentials.',
            ]);
        }
    }

}
