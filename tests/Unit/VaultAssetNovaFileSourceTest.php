<?php

namespace Tests\Unit;

use App\Enums\VaultAccessLevel;
use App\Enums\VaultCategory;
use App\Models\VaultAsset as VaultAssetModel;
use App\Nova\VaultAsset;
use Illuminate\Http\UploadedFile;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tests\TestCase;

class VaultAssetNovaFileSourceTest extends TestCase
{
    public function test_create_form_hides_upload_and_url_until_a_source_is_chosen(): void
    {
        $fields = $this->creationFields([]);

        $this->assertFalse($fields->firstWhere('attribute', 'file_path')->visible);
        $this->assertFalse($fields->firstWhere('attribute', 'file_url')->visible);
    }

    public function test_choosing_upload_shows_only_the_file_field(): void
    {
        $fields = $this->creationFields(['file_source' => VaultAsset::FILE_SOURCE_UPLOAD]);

        $this->assertTrue($fields->firstWhere('attribute', 'file_path')->visible);
        $this->assertFalse($fields->firstWhere('attribute', 'file_url')->visible);
    }

    public function test_choosing_url_shows_only_the_url_field(): void
    {
        $fields = $this->creationFields(['file_source' => VaultAsset::FILE_SOURCE_URL]);

        $this->assertFalse($fields->firstWhere('attribute', 'file_path')->visible);
        $this->assertTrue($fields->firstWhere('attribute', 'file_url')->visible);
    }

    public function test_upload_without_a_file_is_rejected(): void
    {
        $validator = VaultAsset::validatorForCreation($this->createRequest([
            'file_source' => VaultAsset::FILE_SOURCE_UPLOAD,
        ]));

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('file_path'));
        $this->assertFalse($validator->errors()->has('file_url'));
    }

    public function test_url_without_a_link_is_rejected(): void
    {
        $validator = VaultAsset::validatorForCreation($this->createRequest([
            'file_source' => VaultAsset::FILE_SOURCE_URL,
            'file_url' => '',
        ]));

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('file_url'));
        $this->assertFalse($validator->errors()->has('file_path'));
    }

    public function test_a_pasted_url_passes_file_source_validation(): void
    {
        $validator = VaultAsset::validatorForCreation($this->createRequest([
            'file_source' => VaultAsset::FILE_SOURCE_URL,
            'file_url' => 'https://bodypoint.com/wp-content/uploads/guide.pdf',
        ]));

        $this->assertFalse($validator->errors()->has('file_source'));
        $this->assertFalse($validator->errors()->has('file_path'));
        $this->assertFalse($validator->errors()->has('file_url'));
    }

    public function test_an_upload_passes_file_source_validation(): void
    {
        $file = UploadedFile::fake()->create('guide.pdf', 20, 'application/pdf');
        $request = $this->createRequest(
            ['file_source' => VaultAsset::FILE_SOURCE_UPLOAD],
            ['file_path' => $file]
        );

        $validator = VaultAsset::validatorForCreation($request);

        $this->assertFalse($validator->errors()->has('file_source'));
        $this->assertFalse($validator->errors()->has('file_path'));
        $this->assertFalse($validator->errors()->has('file_url'));
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function creationFields(array $payload)
    {
        $request = $this->createRequest($payload);

        return (new VaultAsset(new VaultAssetModel()))
            ->creationFields($request)
            ->applyDependsOn($request);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, UploadedFile>  $files
     */
    private function createRequest(array $payload, array $files = []): NovaRequest
    {
        return NovaRequest::create('/nova-api/vault-assets', 'POST', array_merge([
            'editing' => 'true',
            'editMode' => 'create',
            'title' => 'Stayflex Guide',
            'category' => VaultCategory::MarketingCollateral->value,
            'access_level' => VaultAccessLevel::Open->value,
        ], $payload), [], $files);
    }
}
