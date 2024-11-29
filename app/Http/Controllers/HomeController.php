<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Media;
use App\Models\User;
use App\Services\SysproService;
use Exception;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Display the category details.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
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

    public function changeCustomer(Request $request){
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
        try{
            session()->put('customer_id', $request->customer_id);
            $customer_id = getCustomerId();
            $url = 'GetCustomerDetails/' . $customer_id;
            $get_customer_details = SysproService::getCustomerDetails($url);
            session()->put('customer_details', $get_customer_details);
            session()->put('customer_address', $get_customer_details['ShipToAddresses'][0]);
            if($get_customer_details){
                return Response::json(['success' => true,'message' => 'Customer Changed Successfully']);
            }else{
                return Response::json(['success' => false,'message' => 'Something went wrong']);
            }
        } catch (Exception $e) {
            return Response::json(['success' => false,'message' => $e->getMessage()]);
        }
    }
}
