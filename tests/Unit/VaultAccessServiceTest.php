<?php

namespace Tests\Unit;

use App\Enums\VaultAccessLevel;
use App\Enums\VaultFileType;
use App\Services\Vault\VaultAccessService;
use PHPUnit\Framework\TestCase;

class VaultAccessServiceTest extends TestCase
{
    private VaultAccessService $access;

    protected function setUp(): void
    {
        parent::setUp();
        $this->access = new VaultAccessService();
    }

    public function test_a_missing_class_does_not_restrict_pricing(): void
    {
        $this->assertNull($this->access->allowedPricingKeys(null));
        $this->assertNull($this->access->allowedPricingKeys(''));
    }

    public function test_mapped_classes_keep_the_historical_price_lists(): void
    {
        $this->assertSame(
            ['Americas', 'Retail Price List', 'Dealer Price List'],
            $this->access->allowedPricingKeys('VA')
        );
        $this->assertSame(
            ['Americas', 'Retail Price List'],
            $this->access->allowedPricingKeys('AM')
        );
        $this->assertSame(
            ['International'],
            $this->access->allowedPricingKeys('WI')
        );
        $this->assertSame([], $this->access->allowedPricingKeys('WM'));
    }

    public function test_an_unknown_class_sees_no_price_lists(): void
    {
        $this->assertSame([], $this->access->allowedPricingKeys('ZZ'));
    }

    public function test_file_type_is_derived_from_the_url(): void
    {
        $this->assertSame(VaultFileType::Pdf, VaultFileType::fromUrl('https://bodypoint.com/a/file.PDF'));
        $this->assertSame(VaultFileType::Pptx, VaultFileType::fromUrl('https://bodypoint.com/a/deck.pptx'));
        $this->assertSame(VaultFileType::Xlsx, VaultFileType::fromUrl('https://bodypoint.com/a/list.xlsx'));
        $this->assertSame(VaultFileType::Zip, VaultFileType::fromUrl('https://example.com/kit.zip'));
        $this->assertSame(VaultFileType::Folder, VaultFileType::fromUrl('https://www.dropbox.com/scl/fo/abc'));
        $this->assertSame(VaultFileType::Link, VaultFileType::fromUrl('/'));
        $this->assertSame(VaultAccessLevel::Pricing, VaultAccessLevel::from('pricing'));
    }
}
