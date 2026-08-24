<?php

namespace App\Enums;

enum VaultCategory: string
{
    case MediaAssets = 'media-assets';
    case MarketingCollateral = 'marketing-collateral';
    case PricingGuide = 'pricing-guide';
    case Presentations = 'presentations';
    case ProductAndTechnical = 'product-and-technical';
    case ActiveCampaigns = 'active-campaigns';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public static function fromNullable(mixed $value): ?self
    {
        if ($value instanceof self) {
            return $value;
        }

        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        return self::tryFrom(strtolower(trim($value)));
    }

    public function label(): string
    {
        return match ($this) {
            self::MediaAssets => 'Media Assets',
            self::MarketingCollateral => 'Marketing Collateral',
            self::PricingGuide => 'Pricing Guide',
            self::Presentations => 'Presentations',
            self::ProductAndTechnical => 'Product and Technical',
            self::ActiveCampaigns => 'Active Campaigns',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::MediaAssets => 'Logos, photo releases and photo libraries',
            self::MarketingCollateral => 'Sell sheets, brochures, ads, catalogs and event graphics',
            self::PricingGuide => 'Dealer, retail and regional price lists',
            self::Presentations => 'Product and training slide decks',
            self::ProductAndTechnical => 'Product instructions and technical bulletins',
            self::ActiveCampaigns => 'In-market campaign kits and artwork',
        };
    }
}
