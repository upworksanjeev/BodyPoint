<?php

namespace App\Enums;

/**
 * The dealer's explicit "order or quote" choice, made once at the cart and
 * carried through every later step of the checkout flow.
 */
enum CheckoutIntent: string
{
    case Order = 'order';
    case Quote = 'quote';

    /**
     * Resolve an untrusted value (request input, database column) into an intent
     * without ever throwing, so a stale or hand-edited value degrades to "no
     * choice made yet" instead of a 500.
     */
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
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public function isOrder(): bool
    {
        return $this === self::Order;
    }

    public function isQuote(): bool
    {
        return $this === self::Quote;
    }

    /**
     * Label of the cart button that starts this path.
     */
    public function ctaLabel(): string
    {
        return match ($this) {
            self::Order => 'Place Order',
            self::Quote => 'Save as Quote',
        };
    }

    /**
     * Review screen this path continues to after the payment step.
     *
     * Tickets 2-3 collapse these into a single shared review screen; until then
     * each path keeps its existing page.
     */
    public function reviewRouteName(): string
    {
        return match ($this) {
            self::Order => 'checkout',
            self::Quote => 'quote',
        };
    }

    /**
     * Portal permission (checked against the active AssociateCustomer) that a
     * dealer must hold to follow this path.
     */
    public function permission(): string
    {
        return match ($this) {
            self::Order => 'placeOrders',
            self::Quote => 'getQuotes',
        };
    }
}
