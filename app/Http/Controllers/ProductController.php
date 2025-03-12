<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostRequest;
use App\Models\AssociateCustomer;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\AttributeCategory;
use App\Models\VariationAttribute;
use App\Models\Variation;
use App\Models\SuccessStory;
use App\Models\Media;
use App\Services\SysproService;

class ProductController extends Controller
{
    /**
     * Display the category details.
     */
    public function index($name, Request $request)
    {
        $categories = Category::all();

        $showFindPartnerButton = false;
        $customer_id =  null;
        
        try {
            $customer_id = getCustomerId();
        } catch (\Exception $e) {
            $showFindPartnerButton = true;
        }

        
        
        if($customer_id) {
            $customer = AssociateCustomer::where([
                ['user_id', Auth::id()],
                ['customer_id', $customer_id]
            ])->first();
    
    
            $rolesToCheck = ['VA', 'WC', 'WI', 'WM', 'WR', 'WL'];

            
            if ( $customer && $customer->role && in_array($customer->role, $rolesToCheck)) {
                $showFindPartnerButton = true;
            }

        }
        

        $product = Product::with(['media', 'SuccessStory','attribute'])->where('slug', $name)->first();
        if(!empty(auth()->user()->default_customer_id)){
            $customer_id = getCustomerId();
            $url = 'GetCustomerDetails/' . $customer_id;
            $syspro_products = SysproService::getCustomerDetails($url);
            if ($syspro_products && $syspro_products['CustomerClass'] && in_array($syspro_products['CustomerClass'], $rolesToCheck)) {
                $showFindPartnerButton = true;

            }
            if (!empty($syspro_products)) {
                session()->put('customer_details', $syspro_products);
                $product['discount'] = $syspro_products['CustomerDiscountPercentage'];
                $existingKey = array_search($product->sku,array_column($syspro_products['PriceList'], 'StockCode'));
                if(!empty($existingKey)){
                    $product['price'] = $syspro_products['PriceList'][$existingKey]['DealerPrice'];
                    $product['msrp'] = $syspro_products['PriceList'][$existingKey]['MSRPPrice'];
                }
            }
        }

        if (!empty(auth()->user()->default_customer_id)) {
            $url = 'ListStock';
            SysproService::listStock($url);
        }

        if (isset($product['id'])) {
            $products = CategoryProduct::with(['category'])->where('product_id', $product['id'])->get();
            $productattr = AttributeCategory::leftjoin('attributes', 'attribute_categories.id', '=', 'att_cat_id')
                ->leftjoin('product_attributes', 'attributes.id', '=', 'attr_id')
                ->where('prod_id', $product['id'])->orderby('product_attributes.attr_order')->get();

            $i = 0;
            $category = [];
            $attribute = [];
            /* attributes and their categories name for this product */
            $j = 0;
            foreach ($productattr as $k => $v) {
                if (in_array($v['category'], $category)) {
                    $key = array_search($v['category'], $category);
                    $j++;
                    $attribute[$key][$j]['id'] = $v['attr_id'];
                    $attribute[$key][$j]['product_attr_id'] = $v['id'];
                    $attribute[$key][$j]['attribute'] = $v['attribute'];
                    $attribute[$key][$j]['small_description'] = $v['small_description'];
                    $attribute[$key][$j]['image'] = $v['image'];
                } else {
                    $j = 0;

                    $category[$i] = $v['category'];
                    $attribute[$i][$j]['id'] = $v['attr_id'];
                    $attribute[$i][$j]['product_attr_id'] = $v['id'];
                    $attribute[$i][$j]['attribute'] = $v['attribute'];
                    $attribute[$i][$j]['small_description'] = $v['small_description'];
                    $attribute[$i][$j]['image'] = $v['image'];
                    $i++;
                }
            }
            if ($product['discount'] != '' && $product['discount'] > 0) {
                $product['discount_in_price'] = round(($product['price'] * $product['discount']) / 100, 2);
                $product['discount_price'] = ($product['price'] - $product['discount_in_price']);
            } else {
                $product['discount_price'] = $product['price'];
            }

            return view('product', array(
                'categories' => $categories,
                'category' => $category,
                'attribute' => $attribute,
                'product' => $product,
                'products' => $products,
                'showFindPartnerButton' => $showFindPartnerButton
            ));
        } else {
            return view('product', [
                'error' => 'No product Found!'
            ]);
        }
    }

    private function filterAttributes($data, $sizesToRemove) {
    foreach ($data as &$subArray) {
        if (is_array($subArray)) {
            $subArray = array_values(array_filter($subArray, function ($item) use ($sizesToRemove) {
                return !in_array($item['attribute'], $sizesToRemove);
            }));
        }
    }
    return $data;
}

    /**
     * return new attribute according to available variation list for a product
     */
    public function getNextAttribute(Request $request)
    {
        $product = Product::with(['media'])->where('id', $request->product_id)->first();
        $var_att_ids = VariationAttribute::select('variation_id')->where('product_attribute_id', $request->product_att_id)->get();
        $attr = [];
        $productattr = [];

        foreach ($var_att_ids as $k => $v) {
            $var_att = VariationAttribute::select('product_attribute_id')->where('variation_id', $v->variation_id)->get()->toArray();
            foreach ($var_att as $k1 => $v1) {
                if (!in_array($v1['product_attribute_id'], $attr)) {
                    $attr[] = $v1['product_attribute_id'];
                    $productattr[] = AttributeCategory::leftjoin('attributes', 'attribute_categories.id', '=', 'att_cat_id')
                        ->leftjoin('product_attributes', 'attributes.id', '=', 'attr_id')
                        ->where('product_attributes.id', $v1['product_attribute_id'])->first();
                }
            }
        }
        $i = 0;
        $category = [];
        $attribute = [];
        /* attributes and their categories name for this product */
        $j = 0;

        $productattr = collect($productattr)->sortBy('attr_order')->values();
        foreach ($productattr as $k => $v) {
            if (in_array($v['category'], $category)) {
                $key = array_search($v['category'], $category);
                $j++;
                $attribute[$key][$j]['id'] = $v['attr_id'];
                $attribute[$key][$j]['product_attr_id'] = $v['id'];
                $attribute[$key][$j]['attribute'] = $v['attribute'];
                $attribute[$key][$j]['small_description'] = $v['small_description'];
                $attribute[$key][$j]['image'] = $v['image'];
            } else {
                $j = 0;
                $category[$i] = $v['category'];
                $attribute[$i][$j]['id'] = $v['attr_id'];
                $attribute[$i][$j]['product_attr_id'] = $v['id'];
                $attribute[$i][$j]['attribute'] = $v['attribute'];
                $attribute[$i][$j]['small_description'] = $v['small_description'];
                $attribute[$i][$j]['image'] = $v['image'];
                $i++;
            }
        }

        // Added a static condition to display the correct sizes. This function needs a complete rewrite in the future.
        if ($request->product_id == 230 && $request->index == 1) {
            $sizesToRemove = [];

            if ($request->product_att_id == 1429 && in_array($request->rootAttributeId, [1427, 1436])) {
                $sizesToRemove = ($request->attr_count == 1) ? ['S32', 'M36', 'L62'] : ['S32', 'S38'];
            } elseif ($request->product_att_id == 1430 && $request->rootAttributeId == 1427) {
                $sizesToRemove = ['S38'];
            }

            if (!empty($sizesToRemove)) {
                $attribute = $this->filterAttributes($attribute, $sizesToRemove);
            }
        }

        if ($request->product_id == 223 && $request->index == 1) {
            $sizesToRemove = [];

            if ($request->product_att_id == 1400) {
                if ($request->rootAttributeId == 1397 && $request->attr_count == 3) {
                    $sizesToRemove = ['L82', 'L92'];
                } elseif ($request->rootAttributeId == 1398 && $request->attr_count == 2) {
                    $sizesToRemove = ['S32', 'S38', 'L82', 'L92'];
                } elseif ($request->rootAttributeId == 1399 && $request->attr_count == 1) {
                    $sizesToRemove = ['L62', 'L82', 'L92'];
                }
            } elseif ($request->product_att_id == 1401 && $request->rootAttributeId == 1398 && $request->attr_count == 2) {
                $sizesToRemove = ['S38'];
            }

            if ($sizesToRemove) {
                $attribute = $this->filterAttributes($attribute, $sizesToRemove);
            }
        }



        
        return view('components.attribute', [
            'index' => $request->index + 1,
            'attribute' => $attribute,
            'category' => $category,
            'product' => $product
        ]);
    }

    /**
     * return list of product on basis of search keyword
     */
    public function productSearch(Request $request)
    {
        $search = $request->searchinput;
        if ($search != '') {
            $categories = Category::all();
            $products = Product::with(['media'])->where('name', 'like', '%' . $request->searchinput . '%')->paginate(16);
            return view('search', ['products' => $products, 'searchinput' => $search, 'categories' => $categories]);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Get Variation Price and sku according to selected attributes
     */
    public function getVariationPrice(Request $request)
    {
        if ($request->has('pro_att_id')) {
            foreach ($request->pro_att_id as $k => $v) {
                $variation[] = VariationAttribute::select('variation_id')->where('product_attribute_id', $v)->get()->toArray();
            }
            $varations = [];
            $abc = [];
            foreach ($variation as $k => $v) {
                foreach ($v as $x => $y) {
                    $z = $y['variation_id'];
                    if (in_array($z, $varations)) {
                        $abc[$z] += 1;
                    } else {
                        $varations[] = $z;
                        $abc[$z] = 1;
                    }
                }
            }
            $key = array_search(count($request->pro_att_id), $abc);

            if ($key != '') {
                $variation = Variation::with(['product'])->where('id', $key)->first();
            }
        }
        $product = Product::with(['media'])->where('id', $request->product_id)->first();
        $product_available = false;
        
        if (!empty(auth()->user()->default_customer_id)) {
            $customer_id = getCustomerId();
            $url = 'GetCustomerDetails/' . $customer_id;
            $syspro_products = SysproService::getCustomerDetails($url);
            if (!empty($syspro_products['PriceList'])) {
                session()->put('customer_details', $syspro_products);
                $product->discount = $syspro_products['CustomerDiscountPercentage'];
                if(!empty($variation)){
                    $variation['discount'] = $syspro_products['CustomerDiscountPercentage'];
                }
                if(!empty($product->sku)){
                    $existingStockInProduct = array_search($product->sku,array_column($syspro_products['PriceList'], 'StockCode'));
                    if(!empty($existingStockInProduct)){
                        $product_available = true;
                        $product['price'] = $syspro_products['PriceList'][$existingStockInProduct]['DealerPrice'];
                        $product['msrp'] = $syspro_products['PriceList'][$existingStockInProduct]['MSRPPrice'];
                    }
                }
                if(!empty($variation->sku)){
                    $existingStockInVariation = array_search($variation->sku,array_column($syspro_products['PriceList'], 'StockCode'));
                    if(!empty($existingStockInVariation)){
                        $product_available = true;
                        $variation->price = $syspro_products['PriceList'][$existingStockInVariation]['DealerPrice'];
                        $variation->msrp = $syspro_products['PriceList'][$existingStockInVariation]['MSRPPrice'];
                    }
                }

            }
        }
        if(!empty($variation->id)){
            $final_data['variation_id'] = $variation->id;
        }
        $final_data['sku'] = $variation->sku ?? $product->sku;
        $final_data['msrp'] = $variation->msrp ?? $product->msrp;
        $final_data['price'] = $variation->price ?? $product->price;
        $final_data['discount'] = $variation->discount ?? $product->discount;
        if ($final_data['discount'] != '' && $final_data['discount'] > 0) {
            $final_data['discount_in_price'] = round(($final_data['price'] * $final_data['discount']) / 100, 2);
            $final_data['discount_price'] = ($final_data['price'] - $final_data['discount_in_price']);
        } else {
            $final_data['discount_price'] = $final_data['price'];
        }
        $html = view('components.product-price', ['product' => $final_data])->render();
        return response()->json(['html' => $html,'product_available' => $product_available, 'is_auth_user' =>Auth::check()]);
    }

    /**
     * Save success story
     */
    public function addStory(Request $request)
    {
        $user = Auth::user();
        $image = '';
        if ($request->has('image')) {
            $image = Storage::disk('public')->put('success_story', $request->file('image'));
        }
        if ($request->has('product_id')) {
            $story = SuccessStory::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'title' => $request->title,
                'youtube' => $request->youtube,
                'image' => $image,
                'story' => $request->story,
            ]);
        }
        return redirect()->route('product', $request->product_slug);
    }

    /**
     * Get success story
     */
    public function successStory(Request $request) {}
}
