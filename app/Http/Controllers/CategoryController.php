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

            $productsQuery = CategoryProduct::with(['product.media'])
                ->whereIn('category_id', $cat)
                ->whereHas('product', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->select('product_id')
                ->groupBy('product_id');

            // ✅ Manual sorting if sorted_product_ids exists
            $sortedIds = [];
            if (!empty($category->sorted_product_ids)) {
                $decoded = json_decode($category->sorted_product_ids, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $sortedIds = array_filter($decoded, fn($id) => is_numeric($id));
                }
            }

            if (!empty($sortedIds)) {
                // Get all product IDs from current query
                $allProductIds = (clone $productsQuery)->pluck('product_id')->toArray();

                // Merge: sorted first, then the rest
                $finalSortedIds = array_values(array_unique(array_merge(
                    array_intersect($sortedIds, $allProductIds),
                    array_diff($allProductIds, $sortedIds)
                )));

                // Apply sorting without filtering anything out
                $productsQuery->orderByRaw('FIELD(product_id, ' . implode(',', $finalSortedIds) . ')');
            }

            $products = $productsQuery->paginate(16);
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
