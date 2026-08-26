<?php

namespace App\Support\Vault;

use App\Models\VaultAsset;

/**
 * Upserts flattened catalogue rows. File location, category and type come from
 * the seed; tags and shelf flags that marketing has already edited are left
 * alone on subsequent runs.
 */
class VaultCatalogImporter
{
    /**
     * Columns that describe the hosted file. Safe to refresh from the seed.
     *
     * @var array<int, string>
     */
    private const FILE_COLUMNS = [
        'title',
        'file_url',
        'image_url',
        'category',
        'sub_category',
        'group_name',
        'file_type',
        'published_at',
        'access_level',
        'pricing_key',
        'is_active',
        'sort_order',
    ];

    /**
     * @var array<int, string>
     */
    private const MARKETING_COLUMNS = [
        'tags',
        'is_frequently_used',
        'is_newly_added',
        'is_tour_starter',
    ];

    public function __construct(private readonly VaultCatalogFlattener $flattener)
    {
    }

    /**
     * @return array{created: int, updated: int, total: int}
     */
    public function import(): array
    {
        $created = 0;
        $updated = 0;

        foreach ($this->flattener->flatten() as $record) {
            $existing = VaultAsset::query()->where('slug', $record['slug'])->first();

            if ($existing === null) {
                VaultAsset::query()->create($record);
                $created++;

                continue;
            }

            $existing->fill($this->attributesForExisting($record, $existing));
            $existing->save();
            $updated++;
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'total' => $created + $updated,
        ];
    }

    /**
     * @param  array<string, mixed>  $record
     * @return array<string, mixed>
     */
    private function attributesForExisting(array $record, VaultAsset $existing): array
    {
        $attributes = [];

        foreach (self::FILE_COLUMNS as $column) {
            if ($column === 'file_url' && filled($existing->file_path)) {
                continue;
            }

            $attributes[$column] = $record[$column];
        }

        foreach (self::MARKETING_COLUMNS as $column) {
            if ($this->marketingFieldIsUntouched($existing, $column)) {
                $attributes[$column] = $record[$column];
            }
        }

        return $attributes;
    }

    private function marketingFieldIsUntouched(VaultAsset $existing, string $column): bool
    {
        return match ($column) {
            'tags' => $existing->tagList() === [],
            default => $existing->{$column} === false,
        };
    }
}
