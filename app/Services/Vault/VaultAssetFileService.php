<?php

namespace App\Services\Vault;

use App\Enums\VaultFileType;
use App\Models\VaultAsset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One place for "upload a file" vs "paste an existing URL" on Vault assets.
 *
 * Uploads live on the public disk; file_url is always the downloadable link
 * the Partner Vault UI uses, whether that is /storage/vault/... or WordPress.
 */
class VaultAssetFileService
{
    public const DIRECTORY = 'vault';

    public function disk(): string
    {
        return (string) config('vault.upload_disk', 'public');
    }

    /**
     * @return array{file_path: string, file_url: string, file_type: string}
     */
    public function storeUpload(UploadedFile $file, object $asset): array
    {
        if ($asset instanceof VaultAsset) {
            $this->deleteLocalFile($asset);
        }

        $path = $file->storeAs(
            self::DIRECTORY.'/'.now()->format('Y/m'),
            $this->filename($file),
            $this->disk()
        );

        return [
            'file_path' => $path,
            'file_url' => $this->publicUrl($path),
            'file_type' => VaultFileType::fromUrl($file->getClientOriginalName())->value,
        ];
    }

    public function useExternalUrl(VaultAsset $asset, string $url): void
    {
        $url = trim($url);

        if ($asset->file_path && $this->publicUrl($asset->file_path) !== $url) {
            $this->deleteLocalFile($asset);
            $asset->file_path = null;
        }

        $asset->file_url = $url;
    }

    public function deleteLocalFile(VaultAsset $asset): void
    {
        $path = $asset->file_path;
        if (!is_string($path) || $path === '') {
            return;
        }

        Storage::disk($this->disk())->delete($path);
    }

    public function filename(UploadedFile $file): string
    {
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = strtolower($file->getClientOriginalExtension());

        $name = ($base !== '' ? $base : 'asset').'-'.Str::lower(Str::random(6));

        return $extension !== '' ? $name.'.'.$extension : $name;
    }

    public function publicUrl(string $path): string
    {
        return Storage::disk($this->disk())->url($path);
    }
}
