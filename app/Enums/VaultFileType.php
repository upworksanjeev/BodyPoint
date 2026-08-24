<?php

namespace App\Enums;

enum VaultFileType: string
{
    case Pdf = 'pdf';
    case Pptx = 'pptx';
    case Xlsx = 'xlsx';
    case Docx = 'docx';
    case Zip = 'zip';
    case Folder = 'folder';
    case Image = 'image';
    case Link = 'link';

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

    /**
     * Derive a type from the hosted URL. Dates and hosts vary; the extension
     * (or Dropbox folder) is the reliable signal.
     */
    public static function fromUrl(string $url): self
    {
        $url = trim($url);

        if ($url === '' || $url === '/') {
            return self::Link;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        if (str_contains($host, 'dropbox.com')) {
            return self::Folder;
        }

        $path = strtolower((string) parse_url($url, PHP_URL_PATH));
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return match ($extension) {
            'pdf' => self::Pdf,
            'ppt', 'pptx' => self::Pptx,
            'xls', 'xlsx' => self::Xlsx,
            'doc', 'docx' => self::Docx,
            'zip' => self::Zip,
            'png', 'jpg', 'jpeg', 'gif', 'webp', 'svg' => self::Image,
            default => self::Link,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Pdf => 'PDF',
            self::Pptx => 'PowerPoint',
            self::Xlsx => 'Spreadsheet',
            self::Docx => 'Document',
            self::Zip => 'ZIP',
            self::Folder => 'Folder',
            self::Image => 'Image',
            self::Link => 'Link',
        };
    }

    public function actionLabel(): string
    {
        return $this === self::Folder || $this === self::Link ? 'Open' : 'Download';
    }
}
