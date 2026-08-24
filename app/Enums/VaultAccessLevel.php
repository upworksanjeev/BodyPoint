<?php

namespace App\Enums;

enum VaultAccessLevel: string
{
    case Open = 'open';
    case Pricing = 'pricing';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Open to Vault users',
            self::Pricing => 'Pricing (customer class)',
        };
    }
}
