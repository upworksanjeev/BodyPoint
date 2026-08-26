<?php

namespace App\Http\Controllers;

use App\Models\AssociateCustomer;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\CheckoutIntentService;
use App\Services\SysproService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Display the category details.
     */
    public function index(Request $request)
    {
        //$categories = Category::all();
        $categories = Category::where('parent_cat_id', 0)->get();
        if (isset($categories)) {
            $products = Product::with(['media'])->paginate(16);

            if (!empty(auth()->user()->default_customer_id)) {
                $url = 'ListStock';
                SysproService::listStock($url);
            }

            return view('front', [
                'categories' => $categories,
                'products' => $products,
            ]);
        } else {
            return view('front', [
                'error' => 'No Products Found!'
            ]);
        }
    }

    public function changeCustomer(Request $request, CheckoutIntentService $intents)
    {
        $request->validate([
            'customer_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existsInUsers = User::where('default_customer_id', $value)
                        ->orWhereHas('associateCustomers', function ($query) use ($value) {
                            $query->where('customer_id', $value);
                        })->exists();
                    if (!$existsInUsers) {
                        $fail('The selected customer ID does not exist.');
                    }
                },
            ],
        ]);
        try {
            //session()->put('customer_id', $request->customer_id);
            $customer_id = $request->customer_id;
            $url = 'GetCustomerDetails/' . $customer_id;
            $get_customer_details = SysproService::getCustomerDetails($url);

            if ($get_customer_details) {
                session()->put('customer_id', $request->customer_id);
                session()->put('customer_details', $get_customer_details);
                session()->put('customer_address', $get_customer_details['ShipToAddresses'][0]);

                // Pricing and permissions belong to the account, so any in-progress
                // order-or-quote choice is reset and taken again at the cart. The
                // finished order or quote belongs to the account being left behind.
                $intents->forget();
                $intents->forgetCompleted();

                $customerClass = $get_customer_details['CustomerClass'] ?? '';


                $authUser = Auth::user();
                if ($customerClass === "") {
                    if (!$authUser->hasRole('Public User')) {
                        $authUser->assignRole('Public User');
                    }
                } else {
                    if (!$authUser->hasRole($customerClass)) {
                        $authUser->assignRole($customerClass);
                    }
                }
                $customer = AssociateCustomer::where([
                    ['user_id', Auth::id()],
                    ['customer_id', $customer_id]
                ])->first();
                if ($customer) {
                    if ($get_customer_details['CustomerClass'] == "") {
                        if (!$customer->hasRole('Public User')) {
                            $customer->assignRole('Public User');
                        }
                    }
                    if (!$customer->hasRole($get_customer_details['CustomerClass'])) {
                        $customer->assignRole($get_customer_details['CustomerClass']);
                    }
                }

                return Response::json(['success' => true, 'message' => 'Customer Changed Successfully']);
            } else {
                return Response::json(['success' => false, 'message' => 'Customer not found']);
            }
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
