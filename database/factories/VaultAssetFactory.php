<?php

namespace Database\Factories;

use App\Enums\VaultAccessLevel;
use App\Enums\VaultCategory;
use App\Enums\VaultFileType;
use App\Models\VaultAsset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<VaultAsset>
 */
class VaultAssetFactory extends Factory
{
    protected $model = VaultAsset::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(8)),
            'title' => Str::title($title),
            'file_url' => 'https://bodypoint.com/wp-content/uploads/2024/07/'.Str::slug($title).'.pdf',
            'image_url' => null,
            'category' => VaultCategory::MarketingCollateral,
            'sub_category' => 'Brochures',
            'group_name' => null,
            'file_type' => VaultFileType::Pdf,
            'published_at' => '2024-07-01',
            'tags' => ['brochure'],
            'access_level' => VaultAccessLevel::Open,
            'pricing_key' => null,
            'is_frequently_used' => false,
            'is_newly_added' => false,
            'is_tour_starter' => false,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function pricing(string $key = 'Americas'): self
    {
        return $this->state(fn () => [
            'category' => VaultCategory::PricingGuide,
            'sub_category' => null,
            'title' => $key,
            'pricing_key' => $key,
            'access_level' => VaultAccessLevel::Pricing,
            'file_type' => VaultFileType::Xlsx,
            'file_url' => 'https://www.bodypoint.com/wp-content/uploads/2026/02/'.$key.'.xlsx',
        ]);
    }

    public function inactive(): self
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
