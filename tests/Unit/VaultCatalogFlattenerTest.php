<?php

namespace Tests\Unit;

use App\Enums\VaultCategory;
use App\Support\Vault\LegacyVaultCatalog;
use App\Support\Vault\VaultCatalogFlattener;
use Tests\TestCase;

class VaultCatalogFlattenerTest extends TestCase
{
    public function test_it_flattens_the_legacy_arrays_into_one_record_per_file(): void
    {
        $records = (new VaultCatalogFlattener(new LegacyVaultCatalog()))->flatten();

        $this->assertGreaterThan(200, count($records));

        $slugs = array_column($records, 'slug');
        $this->assertSame(count($slugs), count(array_unique($slugs)));

        $pricing = array_values(array_filter(
            $records,
            fn (array $row) => $row['category'] === VaultCategory::PricingGuide->value
        ));
        $this->assertCount(4, $pricing);
        $this->assertSame('pricing', $pricing[0]['access_level']);

        $tour = array_values(array_filter(
            $records,
            fn (array $row) => $row['is_tour_starter'] === true
        ));
        $this->assertGreaterThanOrEqual(3, count($tour));

        $inactive = array_values(array_filter(
            $records,
            fn (array $row) => $row['is_active'] === false
        ));
        $this->assertGreaterThanOrEqual(1, count($inactive));
    }

    public function test_frequently_used_files_are_flagged_not_duplicated_when_the_url_already_exists(): void
    {
        $records = (new VaultCatalogFlattener(new LegacyVaultCatalog()))->flatten();
        $productGuideUrl = 'https://www.bodypoint.com/wp-content/uploads/2026/03/Catalog-Product-Guide-BMM002.pdf';

        $matches = array_values(array_filter(
            $records,
            fn (array $row) => $row['file_url'] === $productGuideUrl
        ));

        $this->assertCount(1, $matches);
        $this->assertTrue($matches[0]['is_frequently_used']);
        $this->assertTrue($matches[0]['is_tour_starter']);
    }
}
