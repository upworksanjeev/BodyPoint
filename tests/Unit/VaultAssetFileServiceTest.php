<?php

namespace Tests\Unit;

use App\Enums\VaultFileType;
use App\Models\VaultAsset;
use App\Services\Vault\VaultAssetFileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VaultAssetFileServiceTest extends TestCase
{
    public function test_an_upload_stores_on_the_public_disk_and_sets_the_download_url(): void
    {
        Storage::fake('public');

        $asset = new VaultAsset();
        $file = UploadedFile::fake()->create('Product Guide.pdf', 120, 'application/pdf');

        $stored = (new VaultAssetFileService())->storeUpload($file, $asset);

        Storage::disk('public')->assertExists($stored['file_path']);
        $this->assertStringContainsString('/storage/', $stored['file_url']);
        $this->assertSame(VaultFileType::Pdf->value, $stored['file_type']);
        $this->assertStringEndsWith('.pdf', $stored['file_path']);
    }

    public function test_pasting_a_url_clears_a_previous_upload(): void
    {
        Storage::fake('public');

        $service = new VaultAssetFileService();
        $asset = new VaultAsset(['title' => 'Guide']);
        $stored = $service->storeUpload(
            UploadedFile::fake()->create('old.pdf', 20, 'application/pdf'),
            $asset
        );
        $asset->file_path = $stored['file_path'];
        $asset->file_url = $stored['file_url'];

        $external = 'https://bodypoint.com/wp-content/uploads/2026/03/Catalog.pdf';
        $service->useExternalUrl($asset, $external);

        Storage::disk('public')->assertMissing($stored['file_path']);
        $this->assertNull($asset->file_path);
        $this->assertSame($external, $asset->file_url);
    }
}
