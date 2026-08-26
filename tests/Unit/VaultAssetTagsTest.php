<?php

namespace Tests\Unit;

use App\Models\VaultAsset;
use App\Nova\VaultAsset as VaultAssetResource;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tests\TestCase;

class VaultAssetTagsTest extends TestCase
{
    public function test_tags_are_trimmed_and_deduped_on_save(): void
    {
        $asset = VaultAsset::factory()->create([
            'tags' => ['  Harness ', 'harness', '', 'Upper Body'],
        ]);

        $this->assertSame(['Harness', 'Upper Body'], $asset->fresh()->tagList());

        $asset->delete();
    }

    public function test_tag_options_list_existing_catalog_chips(): void
    {
        $asset = VaultAsset::factory()->create([
            'tags' => ['brochure', 'Sell sheet'],
        ]);

        $options = VaultAsset::tagOptions();

        $this->assertArrayHasKey('brochure', $options);
        $this->assertArrayHasKey('Sell sheet', $options);

        $asset->delete();
    }

    public function test_nova_tags_field_uses_enter_to_add_chips(): void
    {
        $request = NovaRequest::create('/nova-api/vault-assets', 'GET', [
            'editing' => 'true',
            'editMode' => 'create',
        ]);

        $tags = (new VaultAssetResource(new VaultAsset()))
            ->creationFields($request)
            ->firstWhere('attribute', 'tags');

        $this->assertNotNull($tags);
        $this->assertSame('multiselect-field', $tags->component);
        $this->assertTrue($tags->meta['taggable'] ?? false);
    }

    public function test_sort_order_is_assigned_when_omitted_on_create(): void
    {
        $expected = (int) VaultAsset::query()->max('sort_order') + 1;

        $asset = VaultAsset::factory()->make();
        unset($asset['sort_order']);
        $asset->save();

        $this->assertSame($expected, $asset->sort_order);

        $asset->delete();
    }

    public function test_nova_create_form_does_not_include_sort_order(): void
    {
        $request = NovaRequest::create('/nova-api/vault-assets', 'GET', [
            'editing' => 'true',
            'editMode' => 'create',
        ]);

        $sortOrder = (new VaultAssetResource(new VaultAsset()))
            ->creationFields($request)
            ->firstWhere('attribute', 'sort_order');

        $this->assertNull($sortOrder);
    }
}
