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

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function store(LoginRequest $request)
    {
        try{
            $user = User::where('email', $request->email)->first();
            if ($user && !empty($user->customer_id)) {
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
                'message' => $e->getMessage()
            ]);
        }
    }

    public function checkPassword(CheckPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if (!empty(auth()->user()->customer_id)) {
                $url = 'GetCustomerDetails/' . auth()->user()->customer_id;
                $get_customer_details = SysproService::getCustomerDetails($url);
                if (!empty($get_customer_details)) {
                    auth()->user()->update([
                        'payment_term_description' => $get_customer_details['PaymentTermDescription']
                    ]);
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
