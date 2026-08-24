<?php

namespace App\Services\Vault;

use App\Enums\VaultAccessLevel;
use App\Services\SysproService;
use Illuminate\Database\Eloquent\Builder;

/**
 * Pricing sheets follow Syspro customer class, matching the historical Vault
 * accordion. Every other asset is visible to anyone who can open the Vault.
 */
class VaultAccessService
{
    /**
     * Known class → price-list titles. Unknown classes see none; a missing
     * class (legacy) sees every price list, which is how the page behaved.
     *
     * @var array<string, array<int, string>>
     */
    private const PRICING_BY_CLASS = [
        'VA' => ['Americas', 'Retail Price List', 'Dealer Price List'],
        'W' => ['Americas', 'Retail Price List', 'Dealer Price List'],
        'WL' => ['Americas', 'Retail Price List', 'Dealer Price List'],
        'WQ' => ['Americas', 'Retail Price List', 'Dealer Price List'],
        'WR' => ['Americas', 'Retail Price List', 'Dealer Price List'],
        'WX' => ['Americas', 'Retail Price List', 'Dealer Price List'],
        'AM' => ['Americas', 'Retail Price List'],
        'WC' => ['Americas', 'Retail Price List', 'International', 'Dealer Price List'],
        'WS' => ['Americas', 'Retail Price List', 'International', 'Dealer Price List'],
        'WI' => ['International'],
        'WM' => [],
    ];

    public function currentCustomerClass(): ?string
    {
        $fromSession = trim((string) getCustomerClass());
        if ($fromSession !== '') {
            return $fromSession;
        }

        $customerId = getCustomerId();
        if (!$customerId) {
            return null;
        }

        try {
            $details = SysproService::getCustomerDetails('GetCustomerDetails/'.$customerId);
        } catch (\Throwable $e) {
            return null;
        }

        $class = is_array($details) ? ($details['CustomerClass'] ?? null) : null;

        return is_string($class) && $class !== '' ? $class : null;
    }

    /**
     * @return array<int, string>|null  null means "do not restrict pricing"
     */
    public function allowedPricingKeys(?string $customerClass): ?array
    {
        if ($customerClass === null || $customerClass === '') {
            return null;
        }

        if (array_key_exists($customerClass, self::PRICING_BY_CLASS)) {
            return self::PRICING_BY_CLASS[$customerClass];
        }

        return [];
    }

    public function restrict(Builder $query, ?string $customerClass): Builder
    {
        $allowed = $this->allowedPricingKeys($customerClass);

        return $query->where(function (Builder $inner) use ($allowed) {
            $inner->where('access_level', VaultAccessLevel::Open->value);

            if ($allowed === null) {
                $inner->orWhere('access_level', VaultAccessLevel::Pricing->value);

                return;
            }

            if ($allowed !== []) {
                $inner->orWhere(function (Builder $pricing) use ($allowed) {
                    $pricing->where('access_level', VaultAccessLevel::Pricing->value)
                        ->whereIn('pricing_key', $allowed);
                });
            }
        });
    }

    public function customerCanAccessVault(): bool
    {
        $customer = getCustomer();
        if ($customer === null) {
            return false;
        }

        try {
            return (bool) $customer->hasPermissionTo('accessVault');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
