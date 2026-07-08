<?php

namespace App\Http\Controllers;

use App\Services\SysproService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    private const LHF_PARENT_SLUG = 'limited-hand-function';

    private const LHF_META_TITLE = 'Limited Hand Function | Bodypoint';

    private const LHF_META_DESCRIPTION = 'Bodypoint\'s Limited Hand Function portfolio: belts, harnesses, joystick handles, and positioning supports engineered for users with limited grip, dexterity, or one-handed function.';

    /** Client-defined sub-category display order on the LHF parent page. */
    private const LHF_SUB_CATEGORY_SLUG_ORDER = [
        'belts-with-duralatch',
        'belts-with-rehab-latch',
        'anchoring-mobility-supports',
        'power-chair-driving',
    ];

    /**
     * Display the category details.
     */
    public function index($name, Request $request, ?string $subCategorySlug = null)
    {
        $subCategorySlug = $subCategorySlug ?? $request->route('subCategorySlug');
        $slug = $subCategorySlug ?? $name;
        $categories = Category::where('parent_cat_id', 0)->get();
        $category = Category::where('slug', $slug)->first();


        if (!empty(auth()->user()->default_customer_id)) {
            $url = 'ListStock';
            SysproService::listStock($url);
        }

        if (isset($category['id'])) {
            $cat[] = $category['id'];
            $subcategory = Category::where('parent_cat_id', $category['id'])
                ->select('id', 'name', 'slug')
                ->get();

            if (count($subcategory) > 0) {
                foreach ($subcategory as $k => $v) {
                    $cat[] = $v['id'];
                }
            }

            if ($this->isLimitedHandFunctionParentPage($category, $subcategory)) {
                return view('category', [
                    'categories' => $categories,
                    'subcategory' => $subcategory,
                    'category' => $category,
                    'productGroups' => $this->getLimitedHandFunctionProductGroups($subcategory),
                    'pageTitle' => self::LHF_META_TITLE,
                    'metaDescription' => self::LHF_META_DESCRIPTION,
                ]);
            }

            if ($this->isLimitedHandFunctionSubCategory($category)) {
                return view('category', [
                    'categories' => $categories,
                    'subcategory' => $subcategory,
                    'category' => $category,
                    'products' => $this->paginateAlphabeticalCategoryProducts($category->id, $request),
                ]);
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

    private function isLimitedHandFunctionParentPage(Category $category, Collection $subcategory): bool
    {
        return $category->slug === self::LHF_PARENT_SLUG
            && (int) $category->parent_cat_id === 0
            && $subcategory->isNotEmpty();
    }

    private function isLimitedHandFunctionSubCategory(Category $category): bool
    {
        if ((int) $category->parent_cat_id <= 0) {
            return false;
        }

        $parent = Category::find($category->parent_cat_id);

        return $parent !== null
            && $parent->slug === self::LHF_PARENT_SLUG
            && (int) $parent->parent_cat_id === 0;
    }

    private function paginateAlphabeticalCategoryProducts(int $categoryId, Request $request): LengthAwarePaginator
    {
        $products = $this->getAlphabeticalCategoryProducts($categoryId);
        $perPage = 16;
        $page = max(1, (int) $request->get('page', 1));
        $total = $products->count();
        $items = $products->forPage($page, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    private function getAlphabeticalCategoryProducts(int $categoryId): Collection
    {
        $products = CategoryProduct::with(['product.media'])
            ->where('category_id', $categoryId)
            ->whereHas('product', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();

        return $this->sortCategoryProductsAlphabetically($products);
    }

    private function sortCategoryProductsAlphabetically(Collection $products): Collection
    {
        return $products
            ->filter(fn ($row) => $row->product !== null)
            ->sortBy(fn ($row) => strtolower($row->product->name ?? ''), SORT_NATURAL)
            ->values();
    }

    /**
     * @return array<int, array{subcategory: Category, products: Collection<int, CategoryProduct>}>
     */
    private function getLimitedHandFunctionProductGroups(Collection $subcategory): array
    {
        $subsBySlug = $subcategory->keyBy('slug');
        $groups = [];
        $orderedSlugs = self::LHF_SUB_CATEGORY_SLUG_ORDER;

        foreach ($orderedSlugs as $slug) {
            $sub = $subsBySlug->get($slug);
            if ($sub) {
                $this->appendProductGroup($groups, $sub);
            }
        }

        foreach ($subcategory as $sub) {
            if (in_array($sub->slug, $orderedSlugs, true)) {
                continue;
            }
            $this->appendProductGroup($groups, $sub);
        }

        return $groups;
    }

    /**
     * @param array<int, array{subcategory: Category, products: Collection<int, CategoryProduct>}> $groups
     */
    private function appendProductGroup(array &$groups, Category $sub): void
    {
        $products = $this->getAlphabeticalCategoryProducts($sub->id);

        if ($products->isNotEmpty()) {
            $groups[] = [
                'subcategory' => $sub,
                'products' => $products,
            ];
        }
    }
}
