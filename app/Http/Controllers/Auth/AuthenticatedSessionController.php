<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SetPasswordRequest;
use App\Models\User;
use App\Services\SysproService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (empty($user->password)) {
                return response()->json([
                    'status' => 'new',
                    'message' => 'No user found. Please set your password.',
                ]);
            }
            return response()->json([
                'status' => 'exists',
                'message' => 'User exists. Please enter your password.',
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
                'message' => 'Incorrect password.',
            ]);
        }
    }

    public function setPassword(SetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password set successfully and logged in!',
            ]);
        } else {
            throw ValidationException::withMessages([
                'email' => 'No user found with the provided email address.',
            ]);
        }
    }
}
