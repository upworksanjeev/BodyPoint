<?php

namespace App\Services\Vault;

use App\Enums\VaultCategory;
use App\Enums\VaultFileType;
use App\Enums\VaultSort;
use App\Models\VaultAsset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VaultCatalogService
{
    public function __construct(private readonly VaultAccessService $access)
    {
    }

    public function visibleQuery(?string $customerClass = null): Builder
    {
        $customerClass ??= $this->access->currentCustomerClass();

        return $this->access->restrict(VaultAsset::query()->active(), $customerClass);
    }

    /**
     * @return Collection<int, VaultAsset>
     */
    public function search(VaultSearchQuery $query, ?string $customerClass = null): Collection
    {
        $builder = $this->visibleQuery($customerClass);

        $this->applyFilters($builder, $query);
        $this->applySort($builder, $query->sort);

        return $builder->get();
    }

    /**
     * @return Collection<int, VaultAsset>
     */
    public function frequentlyUsed(?string $customerClass = null): Collection
    {
        return $this->visibleQuery($customerClass)
            ->frequentlyUsed()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
    }

    /**
     * @return Collection<int, VaultAsset>
     */
    public function newlyAdded(?string $customerClass = null): Collection
    {
        return $this->visibleQuery($customerClass)
            ->newlyAdded()
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * @return Collection<int, VaultAsset>
     */
    public function tourStarters(?string $customerClass = null): Collection
    {
        return $this->visibleQuery($customerClass)
            ->tourStarters()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
    }

    /**
     * @return array<int, array{category: VaultCategory, count: int}>
     */
    public function categorySummaries(?string $customerClass = null): array
    {
        $counts = $this->visibleQuery($customerClass)
            ->selectRaw('category, COUNT(*) as aggregate')
            ->groupBy('category')
            ->pluck('aggregate', 'category');

        $summaries = [];
        foreach (VaultCategory::cases() as $category) {
            $count = (int) ($counts[$category->value] ?? 0);
            if ($count === 0) {
                continue;
            }

            $summaries[] = [
                'category' => $category,
                'count' => $count,
            ];
        }

        return $summaries;
    }

    /**
     * @return array<int, array{name: string, count: int}>
     */
    public function subCategorySummaries(VaultCategory $category, ?string $customerClass = null): array
    {
        $rows = $this->visibleQuery($customerClass)
            ->where('category', $category->value)
            ->whereNotNull('sub_category')
            ->where('sub_category', '!=', '')
            ->selectRaw('sub_category, COUNT(*) as aggregate')
            ->groupBy('sub_category')
            ->orderBy('sub_category')
            ->get();

        return $rows->map(fn ($row) => [
            'name' => (string) $row->sub_category,
            'count' => (int) $row->aggregate,
        ])->all();
    }

    /**
     * Third-level groups (e.g. Hardware Instructions) once a subcategory is chosen.
     *
     * @return array<int, array{name: string, count: int}>
     */
    public function groupSummaries(VaultCategory $category, string $subCategory, ?string $customerClass = null): array
    {
        $rows = $this->visibleQuery($customerClass)
            ->where('category', $category->value)
            ->where('sub_category', $subCategory)
            ->whereNotNull('group_name')
            ->where('group_name', '!=', '')
            ->selectRaw('group_name, COUNT(*) as aggregate')
            ->groupBy('group_name')
            ->orderBy('group_name')
            ->get();

        return $rows->map(fn ($row) => [
            'name' => (string) $row->group_name,
            'count' => (int) $row->aggregate,
        ])->all();
    }

    /**
     * File types that still have at least one visible asset after other filters.
     *
     * @return array<int, VaultFileType>
     */
    public function availableFileTypes(VaultSearchQuery $query, ?string $customerClass = null): array
    {
        $builder = $this->visibleQuery($customerClass);
        $withoutType = new VaultSearchQuery(
            term: $query->term,
            category: $query->category,
            fileType: null,
            subCategory: $query->subCategory,
            groupName: $query->groupName,
            sort: $query->sort,
        );
        $this->applyFilters($builder, $withoutType);

        $values = $builder->clone()
            ->select('file_type')
            ->distinct()
            ->pluck('file_type');

        $types = [];
        foreach (VaultFileType::cases() as $type) {
            $present = $values->contains(fn ($value) => $value === $type || $value === $type->value);
            if ($present) {
                $types[] = $type;
            }
        }

        return $types;
    }

    private function applyFilters(Builder $builder, VaultSearchQuery $query): void
    {
        if ($query->category !== null) {
            $builder->where('category', $query->category->value);
        }

        if ($query->subCategory !== null) {
            $builder->where('sub_category', $query->subCategory);
        }

        if ($query->groupName !== null) {
            $builder->where('group_name', $query->groupName);
        }

        if ($query->fileType !== null) {
            $builder->where('file_type', $query->fileType->value);
        }

        if ($query->term !== '') {
            $term = '%'.$query->term.'%';
            $builder->where(function (Builder $inner) use ($term, $query) {
                $inner->where('title', 'like', $term)
                    ->orWhere('sub_category', 'like', $term)
                    ->orWhere('group_name', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('tags', 'like', $term);

                $matchedCategory = $this->categoryMatchingTerm($query->term);
                if ($matchedCategory !== null) {
                    $inner->orWhere('category', $matchedCategory->value);
                }
            });
        }
    }

    private function applySort(Builder $builder, VaultSort $sort): void
    {
        match ($sort) {
            VaultSort::Newest => $builder->orderByDesc('published_at')->orderBy('title'),
            VaultSort::Type => $builder->orderBy('file_type')->orderBy('title'),
            VaultSort::Name => $builder->orderBy('title'),
        };
    }

    private function categoryMatchingTerm(string $term): ?VaultCategory
    {
        $needle = strtolower($term);

        foreach (VaultCategory::cases() as $category) {
            if (str_contains(strtolower($category->label()), $needle)
                || str_contains($category->value, $needle)) {
                return $category;
            }
        }

        return null;
    }
}
