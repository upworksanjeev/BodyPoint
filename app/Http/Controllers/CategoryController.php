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
        $sortedIds = [];

        if (!empty($category->sorted_product_ids)) {
            $decoded = json_decode($category->sorted_product_ids, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $sortedIds = array_filter($decoded, fn($id) => is_numeric($id));
            }
        }

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

            $query = CategoryProduct::with('product.media')
                ->where('category_id', $category->id)
                ->whereHas('product', function ($query) {
                    $query->whereNull('deleted_at');
                });

            $allProductIds = $query->pluck('product_id')->toArray(); // get all matching product IDs from DB

            if (!empty($sortedIds)) {
                // Merge sortedIds with the remaining ones, maintaining custom order
                $finalSortedIds = array_values(array_unique(array_merge(
                    array_intersect($sortedIds, $allProductIds),
                    array_diff($allProductIds, $sortedIds)
                )));

                $query->whereIn('product_id', $finalSortedIds)
                    ->orderByRaw('FIELD(product_id, ' . implode(',', $finalSortedIds) . ')');
            }
            $products = $query
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
