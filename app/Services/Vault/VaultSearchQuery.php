<?php

namespace App\Services\Vault;

use App\Enums\VaultCategory;
use App\Enums\VaultFileType;
use App\Enums\VaultSort;
use Illuminate\Http\Request;

/**
 * Normalised search/browse inputs shared by the Vault index and category pages.
 */
final class VaultSearchQuery
{
    public function __construct(
        public readonly string $term = '',
        public readonly ?VaultCategory $category = null,
        public readonly ?VaultFileType $fileType = null,
        public readonly ?string $subCategory = null,
        public readonly ?string $groupName = null,
        public readonly VaultSort $sort = VaultSort::Name,
    ) {
    }

    public static function fromRequest(Request $request, ?VaultCategory $forcedCategory = null): self
    {
        $term = trim((string) $request->query('q', ''));
        $subCategory = trim((string) $request->query('sub', ''));
        $groupName = trim((string) $request->query('group', ''));

        return new self(
            term: $term,
            category: $forcedCategory ?? VaultCategory::fromNullable($request->query('category')),
            fileType: VaultFileType::fromNullable($request->query('type')),
            subCategory: $subCategory !== '' ? $subCategory : null,
            groupName: $groupName !== '' ? $groupName : null,
            sort: VaultSort::fromNullable($request->query('sort')),
        );
    }

    public function hasCriteria(): bool
    {
        return $this->term !== ''
            || $this->category !== null
            || $this->fileType !== null
            || $this->subCategory !== null
            || $this->groupName !== null;
    }

    /**
     * Query string for filter chips and sort links, overlaying the given keys.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, string>
     */
    public function toQuery(array $overrides = []): array
    {
        $query = [
            'q' => $this->term !== '' ? $this->term : null,
            'category' => $this->category?->value,
            'type' => $this->fileType?->value,
            'sub' => $this->subCategory,
            'group' => $this->groupName,
            'sort' => $this->sort === VaultSort::Name ? null : $this->sort->value,
        ];

        foreach ($overrides as $key => $value) {
            $query[$key] = $value instanceof \BackedEnum ? $value->value : $value;
        }

        return array_filter(
            $query,
            fn ($value) => $value !== null && $value !== '',
        );
    }
}
