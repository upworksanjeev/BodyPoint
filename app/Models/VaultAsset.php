<?php

namespace App\Models;

use App\Enums\VaultAccessLevel;
use App\Enums\VaultCategory;
use App\Enums\VaultFileType;
use App\Services\Vault\VaultAssetFileService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VaultAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'file_url',
        'file_path',
        'image_url',
        'category',
        'sub_category',
        'group_name',
        'file_type',
        'published_at',
        'tags',
        'access_level',
        'pricing_key',
        'is_frequently_used',
        'is_newly_added',
        'is_tour_starter',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'category' => VaultCategory::class,
        'file_type' => VaultFileType::class,
        'access_level' => VaultAccessLevel::class,
        'published_at' => 'date',
        'tags' => 'array',
        'is_frequently_used' => 'bool',
        'is_newly_added' => 'bool',
        'is_tour_starter' => 'bool',
        'is_active' => 'bool',
        'sort_order' => 'int',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $asset) {
            $raw = $asset->getAttributes()['sort_order'] ?? null;
            if ($raw === null || $raw === '') {
                $asset->sort_order = (int) static::query()->max('sort_order') + 1;
            }
        });

        static::saving(function (self $asset) {
            if (blank($asset->slug)) {
                $asset->slug = Str::slug((string) $asset->title).'-'.Str::lower(Str::random(8));
            }

            if (filled($asset->file_path)) {
                $asset->file_url = app(VaultAssetFileService::class)->publicUrl((string) $asset->file_path);
            }

            if ($asset->file_type === null && filled($asset->file_url)) {
                $asset->file_type = VaultFileType::fromUrl((string) $asset->file_url);
            }

            $asset->tags = self::normalizeTags($asset->tags);
        });

        static::deleting(function (self $asset) {
            app(VaultAssetFileService::class)->deleteLocalFile($asset);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFrequentlyUsed(Builder $query): Builder
    {
        return $query->where('is_frequently_used', true);
    }

    public function scopeNewlyAdded(Builder $query): Builder
    {
        return $query->where('is_newly_added', true);
    }

    public function scopeTourStarters(Builder $query): Builder
    {
        return $query->where('is_tour_starter', true);
    }

    public function hasUsableUrl(): bool
    {
        $url = trim((string) $this->file_url);

        return $url !== '' && $url !== '/';
    }

    /**
     * @return array<int, string>
     */
    public function tagList(): array
    {
        return self::normalizeTags($this->tags);
    }

    /**
     * Unique trimmed tags. Empty values are dropped.
     *
     * @return array<int, string>
     */
    public static function normalizeTags(mixed $value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $value = is_array($decoded) ? $decoded : preg_split('/\s*,\s*/', $value);
        }

        if (!is_array($value)) {
            return [];
        }

        $seen = [];
        $tags = [];

        foreach ($value as $tag) {
            $tag = trim((string) $tag);
            if ($tag === '') {
                continue;
            }

            $key = mb_strtolower($tag);
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $tags[] = $tag;
        }

        return $tags;
    }

    /**
     * Labels already in the catalog, for the Nova chip picker.
     *
     * @return array<string, string>
     */
    public static function tagOptions(): array
    {
        return self::query()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->unique(fn ($tag) => mb_strtolower($tag))
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->mapWithKeys(fn ($tag) => [$tag => $tag])
            ->all();
    }

    public function categoryLabel(): string
    {
        return $this->category instanceof VaultCategory
            ? $this->category->label()
            : (string) $this->category;
    }
}
