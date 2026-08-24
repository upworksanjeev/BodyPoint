<?php

namespace Tests\Feature;

use App\Enums\CheckoutIntent;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\EmergencyModeSetting;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

/**
 * Order and quote review pages collect PO numbers inline instead of a modal.
 */
class InlinePoReviewTest extends TestCase
{
    private ?User $user = null;

    private ?Cart $cart = null;

    private ?Product $product = null;

    protected function setUp(): void
    {
        parent::setUp();

        EmergencyModeSetting::current()->forceFill(['is_enabled' => false])->save();

        $this->product = Product::create([
            'name' => 'Inline PO Review Test Product',
            'sku' => 'IPO-TEST-'.Str::random(6),
            'price' => 10,
            'msrp' => 20,
        ]);

        $this->user = User::create([
            'name' => 'Inline PO Review Test',
            'email' => 'inline-po-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        foreach (['placeOrders' => 'orders', 'getQuotes' => 'quotes'] as $permission => $group) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'], ['group' => $group]);
            $this->user->givePermissionTo($permission);
        }

        $this->cart = Cart::create([
            'user_id' => $this->user->id,
            'total_items' => 1,
            'checkout_intent' => CheckoutIntent::Order->value,
        ]);
        CartItem::create([
            'cart_id' => $this->cart->id,
            'product_id' => $this->product->id,
            'sku' => $this->product->sku,
            'price' => 10,
            'quantity' => 1,
            'msrp' => 20,
            'discount' => 0,
            'discount_price' => 10,
        ]);
    }

    protected function tearDown(): void
    {
        if ($this->cart) {
            CartItem::where('cart_id', $this->cart->id)->delete();
            Cart::where('id', $this->cart->id)->delete();
        }

        if ($this->user) {
            $this->user->syncPermissions([]);
            $this->user->forceDelete();
        }

        if ($this->product) {
            $this->product->forceDelete();
        }

        parent::tearDown();
    }

    public function test_order_review_shows_inline_po_field_without_modal(): void
    {
        $response = $this->actingAs($this->user)->get(route('checkout'));

        $response->assertOk();
        $response->assertSee('id="confirm-order-form"', false);
        $response->assertSee('id="customer-po-number"', false);
        $response->assertSee('name="customer_po_number"', false);
        $response->assertSee('required', false);
        $response->assertDontSee('id="po-number-modal"', false);
    }

    public function test_quote_review_shows_optional_inline_po_field_without_modal(): void
    {
        $this->cart->update(['checkout_intent' => CheckoutIntent::Quote->value]);

        $response = $this->actingAs($this->user)->get(route('quote'));

        $response->assertOk();
        $response->assertSee('id="generate-quote-form"', false);
        $response->assertSee('id="customer-po-number-quote"', false);
        $response->assertSee('(optional)', false);
        $response->assertDontSee('id="po-number-modal-quote"', false);
    }
}
