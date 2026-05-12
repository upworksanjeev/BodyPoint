<?php

namespace App\Support;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;

/**
 * Builds mailto links and plain-text bodies for emergency-mode email ordering.
 * Recipient address comes only from config `bodypoint.emergency_order_email` (env MAIL_EMERGENCY_ORDER_EMAIL).
 */
class EmergencyOrderMailto
{
    /** Stay under typical mailto URL limits (~2000 chars). */
    public const MAX_MAILTO_LENGTH = 1900;

    public static function recipientEmail(): ?string
    {
        $email = config('bodypoint.emergency_order_email');
        if (!is_string($email)) {
            return null;
        }
        $email = trim($email);

        return $email !== '' ? $email : null;
    }

    public static function cartDisabledTooltip(): string
    {
        $email = self::recipientEmail();
        $base = 'Online ordering is temporarily paused. To create a quote or place an order, please call 1-800-547-5716';
        if ($email !== null) {
            return $base . ' or email ' . $email . '.';
        }

        return $base . '.';
    }

    public static function emptyCartEmailTooltip(): string
    {
        return 'Add items to your cart to send an email order.';
    }

    public static function quotePlaceOrderDisabledTooltip(string $quoteNumber): string
    {
        $email = self::recipientEmail();
        $base = 'Online ordering is temporarily paused. To order from this quote, call 1-800-547-5716';
        if ($email !== null) {
            return $base . ' or email ' . $email . ' and reference Quote #' . $quoteNumber . '.';
        }

        return $base . ' and reference Quote #' . $quoteNumber . '.';
    }

    /** Shown when cart has items but MAIL_EMERGENCY_ORDER_EMAIL is not set (mailto cannot be built). */
    public static function emailOrderUnavailableTooltip(): string
    {
        return 'Email order is unavailable. Please call 1-800-547-5716.';
    }

    /**
     * Helper line when mailto may not open the partner's mail client (HTML-safe for {!! !!}).
     * Uses {@see recipientEmail()} — align with partner mailto recipient (e.g. sales@bodypoint.com via env).
     */
    public static function partnerMailtoHelpHtml(): string
    {
        $email = self::recipientEmail();
        $phone = '<a href="tel:+18005475716" class="text-[#00838f] underline font-medium">1-800-547-5716</a>';
        if ($email !== null) {
            $safe = e($email);

            return 'Having trouble? Email <a href="mailto:' . $safe . '" class="text-[#00838f] underline font-medium">' . $safe . '</a> or call ' . $phone . ' directly.';
        }

        return 'Having trouble? Call ' . $phone . ' directly.';
    }

    public static function accountLabel(): string
    {
        $id = getCustomerId();

        return is_string($id) || is_numeric($id) ? (string) $id : '';
    }

    public static function customerDisplayName(): string
    {
        $name = data_get(session('customer_details', []), 'CustomerName');
        if (is_string($name) && trim($name) !== '') {
            return $name;
        }
        $user = auth()->user();
        if ($user && is_string($user->name) && trim($user->name) !== '') {
            return $user->name;
        }

        return 'Partner';
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection|array<int, Cart>|Collection  $carts
     */
    public static function cartLineItems($carts): Collection
    {
        $carts = $carts instanceof Collection ? $carts : collect($carts);
        $cart = $carts->first();
        if (!$cart) {
            return collect();
        }
        $items = $cart->CartItem ?? $cart->cartItem ?? null;
        if ($items === null) {
            return collect();
        }

        return $items instanceof Collection ? $items : collect($items);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection|array<int, Cart>|Collection  $carts
     */
    public static function cartHasItems($carts): bool
    {
        return self::cartLineItems($carts)->isNotEmpty();
    }

    /**
     * Full plain body for mailto and clipboard (before URL length truncation).
     *
     * @param  \Illuminate\Database\Eloquent\Collection|array<int, Cart>|Collection  $carts
     */
    public static function buildCartEmailBody($carts): string
    {
        $items = self::cartLineItems($carts);
        if ($items->isEmpty()) {
            return '';
        }
        $account = self::accountLabel();
        $name = self::customerDisplayName();
        $lines = [
            "Please place the following order for account {$account}:",
            '',
        ];
        $subtotal = 0.0;
        $marked = [];
        foreach ($items as $item) {
            $product = $item->product ?? $item->Product ?? null;
            $productName = $product->name ?? 'Product';
            $sku = (string) ($item->sku ?? '');
            $qty = (int) ($item->quantity ?? 0);
            $net = (float) ($item->discount_price ?? 0);
            $lineTotal = $net * $qty;
            $subtotal += $lineTotal;
            if (!empty($item->marked_for)) {
                $marked[] = (string) $item->marked_for;
            }
            $lines[] = sprintf(
                '%s | Stock Code: %s | Qty: %d | Net Price: $%s',
                $productName,
                $sku,
                $qty,
                number_format($net, 2, '.', '')
            );
        }
        $lines[] = '';
        $lines[] = 'Subtotal: $' . number_format($subtotal, 2, '.', ',');
        $lines[] = '';
        if (count($marked) > 0) {
            $lines[] = 'Marked For: ' . implode(', ', array_unique($marked));
            $lines[] = '';
        }
        $lines[] = 'Thank you,';
        $lines[] = '';
        $lines[] = $name;

        return implode("\n", $lines);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection|array<int, Cart>|Collection  $carts
     */
    public static function buildCartMailtoHref($carts): ?string
    {
        $to = self::recipientEmail();
        if ($to === null) {
            return null;
        }

        if (!self::cartHasItems($carts)) {
            return null;
        }
        $account = self::accountLabel();
        $name = self::customerDisplayName();
        $subject = 'Order Request – Account ' . $account . ' – ' . $name;
        $body = self::buildCartEmailBody($carts);
        $mailto = 'mailto:' . $to . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($body);

        if (strlen($mailto) <= self::MAX_MAILTO_LENGTH) {
            return $mailto;
        }

        $fallbackBody = "Please place the following order for account {$account}:\n\n"
            . 'Full cart details available in Partner Vault — please reference Account #' . $account . ".\n\n"
            . "Thank you,\n\n"
            . $name;
        $mailto = 'mailto:' . $to . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($fallbackBody);

        if (strlen($mailto) <= self::MAX_MAILTO_LENGTH) {
            return $mailto;
        }

        return 'mailto:' . $to . '?subject=' . rawurlencode($subject);
    }

    public static function buildQuoteEmailBody(Order $quote): string
    {
        $account = (string) ($quote->customer_number ?? self::accountLabel());
        $quoteNo = (string) ($quote->purchase_order_no ?? '');
        $date = $quote->created_at ? $quote->created_at->format('F j, Y') : '';
        $lines = [
            'Please place an order based on the following quote:',
            '',
            'Quote Number: ' . $quoteNo,
            'Quote Date: ' . $date,
            'Customer Account: ' . $account,
            '',
        ];
        $items = $quote->OrderItem ?? $quote->orderItem ?? collect();
        $items = $items instanceof Collection ? $items : collect($items);
        $items = $items->filter(function ($item) {
            return $item->action === null || $item->action !== OrderItem::ACTION_DELETE;
        });
        $subtotal = 0.0;
        foreach ($items as $item) {
            $product = $item->product ?? $item->Product ?? null;
            $productName = $product->name ?? 'Product';
            $sku = (string) ($item->sku ?? '');
            $qty = (int) ($item->quantity ?? 0);
            $discountPrice = (float) ($item->discount_price ?? 0);
            $price = (float) ($item->price ?? 0);
            $unit = ((float) $discountPrice == 0.00) ? $price : $discountPrice;
            $lineTotal = $unit * $qty;
            $subtotal += $lineTotal;
            $lines[] = sprintf(
                '%s | Stock Code: %s | Qty: %d | Unit: EA | Total: $%s',
                $productName,
                $sku,
                $qty,
                number_format($lineTotal, 2, '.', '')
            );
        }
        $lines[] = '';
        $lines[] = 'Subtotal: $' . number_format($subtotal, 2, '.', ',');
        $lines[] = '';
        $lines[] = 'Thank you,';

        return implode("\n", $lines);
    }

    public static function buildQuoteMailtoHref(Order $quote): ?string
    {
        $to = self::recipientEmail();
        if ($to === null) {
            return null;
        }

        $account = (string) ($quote->customer_number ?? self::accountLabel());
        $quoteNo = (string) ($quote->purchase_order_no ?? '');
        $subject = 'Order Request – Quote #' . $quoteNo . ' – Account ' . $account;
        $body = self::buildQuoteEmailBody($quote);
        $mailto = 'mailto:' . $to . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($body);

        if (strlen($mailto) <= self::MAX_MAILTO_LENGTH) {
            return $mailto;
        }

        $fallbackBody = "Please place an order based on the following quote:\n\n"
            . 'Please reference Quote #' . $quoteNo . " for full details.\n\n"
            . "Thank you,";
        $mailto = 'mailto:' . $to . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($fallbackBody);

        if (strlen($mailto) <= self::MAX_MAILTO_LENGTH) {
            return $mailto;
        }

        return 'mailto:' . $to . '?subject=' . rawurlencode($subject);
    }
}
