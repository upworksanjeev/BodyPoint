<?php

namespace App\Http\Controllers;

use App\Services\SysproService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryProduct;

class CategoryController extends Controller
{
    /**
     * Display the category details.
     */
    public function index($name, Request $request)
    {
        $name = ucwords(str_replace('-', ' ', $request->subCategorySlug ?? $name));
        $categories = Category::where('parent_cat_id', 0)->get();
        $category = Category::where('name', $name)->first();

        if (!empty(auth()->user()->default_customer_id)) {
            $url = 'ListStock';
            SysproService::listStock($url);
        }

        if (isset($category['id'])) {
            $cat[] = $category['id'];
            $subcategory = Category::where('parent_cat_id', $category['id'])->select('id', 'name')->get();

            if (count($subcategory) > 0) {
                foreach ($subcategory as $k => $v) {
                    $cat[] = $v['id'];
                }
            }

            $products = CategoryProduct::with(['product.media'])
                ->whereIn('category_id', $cat)
                ->whereHas('product', function ($query) {
                    $query->whereNull('deleted_at'); 
                })
                ->select('product_id')
                ->groupBy('product_id')
                ->paginate(16);
            return view('category', [
                'categories' => $categories,
                'subcategory' => $subcategory,
                'category' => $category,
                'products' => $products,
            ]);
        } else {
            return view('category', [
                'error' => 'No Category Found!'
            ]);
        }
    }
}
