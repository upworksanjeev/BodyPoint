<?php

namespace App\Enums;

enum VaultSort: string
{
    case Name = 'name';
    case Newest = 'newest';
    case Type = 'type';

    public static function fromNullable(mixed $value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        if (!is_string($value) || trim($value) === '') {
            return self::Name;
        }

        return self::tryFrom(strtolower(trim($value))) ?? self::Name;
    }

    public function label(): string
    {
        return match ($this) {
            self::Name => 'Name A–Z',
            self::Newest => 'Newest',
            self::Type => 'File type',
        };
    }
}
