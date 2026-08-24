<?php

namespace App\Services;

use App\Http\Controllers\Quote\QuoteController;
use App\Models\Order;

/**
 * Session state and guards for converting a saved quote into an order.
 */
class QuoteConvertService
{
    public const SESSION_QUOTE_ID = 'quote_id';

    public const SESSION_QUOTE_PURCHASE_ORDER_NO = 'quote_purchase_order_no';

    public function remember(int $quoteId, string $purchaseOrderNo): void
    {
        session()->put([
            self::SESSION_QUOTE_ID => $quoteId,
            self::SESSION_QUOTE_PURCHASE_ORDER_NO => $purchaseOrderNo,
        ]);
    }

    public function forget(): void
    {
        session()->forget([
            self::SESSION_QUOTE_ID,
            self::SESSION_QUOTE_PURCHASE_ORDER_NO,
        ]);
    }

    public function isConverting(): bool
    {
        return session()->has(self::SESSION_QUOTE_PURCHASE_ORDER_NO);
    }

    public function quoteId(): ?int
    {
        $id = session(self::SESSION_QUOTE_ID);

        return $id !== null ? (int) $id : null;
    }

    public function purchaseOrderNo(): ?string
    {
        $number = session(self::SESSION_QUOTE_PURCHASE_ORDER_NO);

        return is_string($number) && $number !== '' ? $number : null;
    }

    public function expiresAt(Order $quote): ?\Illuminate\Support\Carbon
    {
        return $quote->created_at?->copy()->addDays(QuoteController::QUOTE_VALID_DAYS);
    }

    public function isExpired(Order $quote): bool
    {
        $expiresAt = $this->expiresAt($quote);

        return $expiresAt !== null && now()->gt($expiresAt);
    }

    /**
     * @return string|null User-facing error when convert must be blocked.
     */
    public function blockedReason(Order $quote): ?string
    {
        if ((string) $quote->customer_number !== (string) getCustomerId()) {
            return 'Quote not found.';
        }

        if ($quote->status !== 'F') {
            return 'This quote has already been converted or can no longer be converted.';
        }

        if ($this->isExpired($quote)) {
            return 'This quote has expired and cannot be converted to an order.';
        }

        return null;
    }
}
