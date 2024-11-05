<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Media;
use App\Services\SysproService;

class HomeController extends Controller
{
    /**
     * Display the category details.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        if (isset($categories)) {
            $products = CategoryProduct::select('product_id')
                ->groupBy('product_id')
                ->with(['product.media'])
                ->paginate(16);

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
        session()->put('customer_id', $request->customer_id);
        $customer_id = session()->get('customer_id') ? session()->get('customer_id') : auth()->user()->default_customer_id;
        $url = 'GetCustomerDetails/' . $customer_id;
        $get_customer_details = SysproService::getCustomerDetails($url);
        session()->put('customer_address', $get_customer_details['ShipToAddresses'][0]);
        return redirect()->back()->with('success', 'Customer Changed successfully');
    }
}
