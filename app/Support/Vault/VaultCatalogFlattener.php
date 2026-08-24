<?php

namespace App\Support\Vault;

use App\Enums\VaultAccessLevel;
use App\Enums\VaultCategory;
use App\Enums\VaultFileType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Turns the nested HomeController-era arrays into one flat record per file.
 *
 * Frequently Used / Newly Added are shelves, not categories: matching rows are
 * flagged rather than duplicated. Broken placeholder URLs stay in the list so
 * marketing can repair them in Nova, but they are imported inactive.
 */
class VaultCatalogFlattener
{
    public function __construct(private readonly LegacyVaultCatalog $catalog)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function flatten(): array
    {
        $records = [];

        $this->ingestCategory($records, VaultCategory::ProductAndTechnical, $this->catalog->productAndTechnical());
        $this->ingestCategory($records, VaultCategory::MarketingCollateral, $this->catalog->marketingCollateral());
        $this->ingestCategory($records, VaultCategory::MediaAssets, $this->catalog->mediaAssets());
        $this->ingestFlat($records, VaultCategory::Presentations, $this->catalog->presentations());
        $this->ingestPricing($records, $this->catalog->pricingGuide());
        $this->ingestCampaigns($records, $this->catalog->activeCampaigns());

        $this->flagByUrl($records, $this->catalog->frequentlyUsed(), 'is_frequently_used', true);
        $this->flagByUrl($records, $this->catalog->newlyAdded(), 'is_newly_added', true);
        $this->flagByUrl($records, $this->catalog->frequentlyUsed(), 'is_tour_starter', true);

        return array_values($records);
    }

    /**
     * Nested trees: subcategory => (assets | group => assets).
     *
     * @param  array<string, mixed>  $tree
     * @param  array<string, array<string, mixed>>  $records
     */
    private function ingestCategory(array &$records, VaultCategory $category, array $tree): void
    {
        foreach ($tree as $subCategory => $branch) {
            if (!is_array($branch)) {
                continue;
            }

            if ($this->isAsset($branch)) {
                $this->push($records, $category, $branch, is_string($subCategory) ? $subCategory : null);

                continue;
            }

            foreach ($branch as $groupOrIndex => $maybeAssets) {
                if ($this->isAsset($maybeAssets)) {
                    $this->push($records, $category, $maybeAssets, is_string($subCategory) ? $subCategory : null);

                    continue;
                }

                if (!is_array($maybeAssets)) {
                    continue;
                }

                foreach ($maybeAssets as $asset) {
                    if ($this->isAsset($asset)) {
                        $this->push(
                            $records,
                            $category,
                            $asset,
                            is_string($subCategory) ? $subCategory : null,
                            is_string($groupOrIndex) ? $groupOrIndex : null,
                        );
                    }
                }
            }
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $assets
     * @param  array<string, array<string, mixed>>  $records
     */
    private function ingestFlat(array &$records, VaultCategory $category, array $assets, ?string $subCategory = null): void
    {
        foreach ($assets as $asset) {
            if ($this->isAsset($asset)) {
                $this->push($records, $category, $asset, $subCategory);
            }
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $assets
     * @param  array<string, array<string, mixed>>  $records
     */
    private function ingestPricing(array &$records, array $assets): void
    {
        foreach ($assets as $asset) {
            if (!$this->isAsset($asset)) {
                continue;
            }

            $this->push($records, VaultCategory::PricingGuide, $asset, null, null, [
                'access_level' => VaultAccessLevel::Pricing->value,
                'pricing_key' => $asset['name'] ?? null,
            ]);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $campaigns
     * @param  array<string, array<string, mixed>>  $records
     */
    private function ingestCampaigns(array &$records, array $campaigns): void
    {
        foreach ($campaigns as $campaign) {
            if (!is_array($campaign) || !isset($campaign['url'])) {
                continue;
            }

            if (!isset($campaign['name'])) {
                $campaign['name'] = 'Pediatric Campaign Kit';
            }

            $this->push($records, VaultCategory::ActiveCampaigns, $campaign);
        }
    }

    /**
     * @param  array<string, array<string, mixed>>  $records
     * @param  array<int, array<string, mixed>>  $assets
     */
    private function flagByUrl(array &$records, array $assets, string $flag, bool $value): void
    {
        foreach ($assets as $asset) {
            if (!$this->isAsset($asset)) {
                continue;
            }

            $url = $this->normalizedUrl((string) ($asset['url'] ?? ''));
            if ($url === '') {
                continue;
            }

            $matched = false;
            foreach ($records as &$record) {
                if ($this->normalizedUrl((string) $record['file_url']) === $url) {
                    $record[$flag] = $value;
                    $matched = true;
                }
            }
            unset($record);

            if (!$matched) {
                $category = $this->guessCategoryForOrphan($asset);
                $this->push($records, $category, $asset, null, null, [$flag => $value]);
            }
        }
    }

    /**
     * @param  array<string, mixed>  $asset
     */
    private function guessCategoryForOrphan(array $asset): VaultCategory
    {
        $name = strtolower((string) ($asset['name'] ?? ''));

        if (str_contains($name, 'campaign')) {
            return VaultCategory::ActiveCampaigns;
        }

        return VaultCategory::MarketingCollateral;
    }

    /**
     * @param  array<string, array<string, mixed>>  $records
     * @param  array<string, mixed>  $asset
     * @param  array<string, mixed>  $overrides
     */
    private function push(
        array &$records,
        VaultCategory $category,
        array $asset,
        ?string $subCategory = null,
        ?string $groupName = null,
        array $overrides = [],
    ): void {
        $url = (string) ($asset['url'] ?? '');
        $title = trim((string) ($asset['name'] ?? ''));
        if ($title === '') {
            $title = $this->titleFromUrl($url);
        }

        $slug = $this->slugFor($title, $url, $category, $subCategory, $groupName);
        $usable = $this->normalizedUrl($url) !== '';

        $record = array_merge([
            'slug' => $slug,
            'title' => $title,
            'file_url' => $url !== '' ? $url : '/',
            'image_url' => $asset['image'] ?? null,
            'category' => $category->value,
            'sub_category' => $subCategory,
            'group_name' => $groupName,
            'file_type' => VaultFileType::fromUrl($url)->value,
            'published_at' => $this->guessPublishedAt($url)?->toDateString(),
            'tags' => $this->seedTags($category, $subCategory, $groupName),
            'access_level' => VaultAccessLevel::Open->value,
            'pricing_key' => null,
            'is_frequently_used' => false,
            'is_newly_added' => false,
            'is_tour_starter' => false,
            'is_active' => $usable,
            'sort_order' => count($records),
        ], $overrides);

        $records[$slug] = $record;
    }

    /**
     * @param  array<string, mixed>  $value
     */
    private function isAsset(mixed $value): bool
    {
        return is_array($value) && array_key_exists('url', $value);
    }

    private function slugFor(
        string $title,
        string $url,
        VaultCategory $category,
        ?string $subCategory,
        ?string $groupName,
    ): string {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'asset';
        }

        $fingerprint = sha1(implode('|', [$category->value, $subCategory, $groupName, $title, $url]));

        return Str::limit($base, 60, '').'-'.substr($fingerprint, 0, 10);
    }

    private function normalizedUrl(string $url): string
    {
        $url = trim($url);

        return ($url === '' || $url === '/') ? '' : $url;
    }

    private function titleFromUrl(string $url): string
    {
        $path = (string) parse_url($url, PHP_URL_PATH);
        $basename = pathinfo($path, PATHINFO_FILENAME);

        return $basename !== '' ? str_replace(['-', '_'], ' ', $basename) : 'Untitled asset';
    }

    private function guessPublishedAt(string $url): ?Carbon
    {
        if (preg_match('#/(\d{4})/(\d{2})/#', $url, $matches) === 1) {
            return Carbon::createFromDate((int) $matches[1], (int) $matches[2], 1);
        }

        if (preg_match('/(20\d{2})[._-](\d{1,2})/', $url, $matches) === 1) {
            $month = (int) $matches[2];
            if ($month >= 1 && $month <= 12) {
                return Carbon::createFromDate((int) $matches[1], $month, 1);
            }
        }

        return null;
    }

    /**
     * Taxonomy crumbs so name + category search works before marketing tags land.
     *
     * @return array<int, string>
     */
    private function seedTags(VaultCategory $category, ?string $subCategory, ?string $groupName): array
    {
        return array_values(array_unique(array_filter([
            $category->label(),
            $subCategory,
            $groupName,
        ])));
    }
}
