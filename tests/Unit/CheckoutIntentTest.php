<?php

namespace Tests\Unit;

use App\Enums\CheckoutIntent;
use PHPUnit\Framework\TestCase;

class CheckoutIntentTest extends TestCase
{
    public function test_it_resolves_the_stored_values(): void
    {
        $this->assertSame(CheckoutIntent::Order, CheckoutIntent::fromNullable('order'));
        $this->assertSame(CheckoutIntent::Quote, CheckoutIntent::fromNullable('quote'));
    }

    public function test_it_tolerates_casing_and_padding(): void
    {
        $this->assertSame(CheckoutIntent::Order, CheckoutIntent::fromNullable(' ORDER '));
        $this->assertSame(CheckoutIntent::Quote, CheckoutIntent::fromNullable("Quote\n"));
    }

    /**
     * An unusable value must mean "no choice made yet" so the dealer is sent back
     * to the cart, never a hard failure on a checkout screen.
     *
     * @dataProvider unusableValues
     */
    public function test_it_returns_null_for_unusable_values(mixed $value): void
    {
        $this->assertNull(CheckoutIntent::fromNullable($value));
    }

    public static function unusableValues(): array
    {
        return [
            'null' => [null],
            'empty string' => [''],
            'whitespace' => ['   '],
            'unknown word' => ['invoice'],
            'integer' => [1],
            'boolean' => [true],
            'array' => [['order']],
        ];
    }

    public function test_it_passes_an_enum_through_unchanged(): void
    {
        $this->assertSame(CheckoutIntent::Quote, CheckoutIntent::fromNullable(CheckoutIntent::Quote));
    }

    public function test_each_path_has_its_own_review_screen_and_permission(): void
    {
        $this->assertSame('checkout', CheckoutIntent::Order->reviewRouteName());
        $this->assertSame('quote', CheckoutIntent::Quote->reviewRouteName());

        $this->assertSame('placeOrders', CheckoutIntent::Order->permission());
        $this->assertSame('getQuotes', CheckoutIntent::Quote->permission());
    }

    public function test_the_paths_are_mutually_exclusive(): void
    {
        $this->assertTrue(CheckoutIntent::Order->isOrder());
        $this->assertFalse(CheckoutIntent::Order->isQuote());

        $this->assertTrue(CheckoutIntent::Quote->isQuote());
        $this->assertFalse(CheckoutIntent::Quote->isOrder());
    }

    public function test_it_exposes_the_cart_button_labels(): void
    {
        $this->assertSame('Place Order', CheckoutIntent::Order->ctaLabel());
        $this->assertSame('Save as Quote', CheckoutIntent::Quote->ctaLabel());
    }

    public function test_values_are_the_only_accepted_request_input(): void
    {
        $this->assertSame(['order', 'quote'], CheckoutIntent::values());
    }
}
