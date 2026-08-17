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
 * Covers the order-or-quote choice: taken at the cart, carried through the flow,
 * and enforced so the wrong path is never reachable.
 *
 * Creates and removes its own account and cart, so it is safe to run against a
 * populated database.
 */
class CheckoutIntentFlowTest extends TestCase
{
    private ?User $user = null;

    private ?Cart $cart = null;

    private ?Product $product = null;

    protected function setUp(): void
    {
        parent::setUp();

        EmergencyModeSetting::current()->forceFill(['is_enabled' => false])->save();

        // Owns its own product so the suite does not depend on seeded catalogue data.
        $this->product = Product::create([
            'name' => 'Checkout Intent Test Product',
            'sku' => 'CI-TEST-'.Str::random(6),
            'price' => 10,
            'msrp' => 20,
        ]);

        $this->user = User::create([
            'name' => 'Checkout Intent Test',
            'email' => 'checkout-intent-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        // Not mass assignable, and the flow sits behind the email-verified gate.
        $this->user->forceFill(['email_verified_at' => now()])->save();

        $permissionGroups = [
            CheckoutIntent::Order->permission() => 'orders',
            CheckoutIntent::Quote->permission() => 'quotes',
        ];

        foreach ($permissionGroups as $permission => $group) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'], ['group' => $group]);
            $this->user->givePermissionTo($permission);
        }

        $this->cart = Cart::create([
            'user_id' => $this->user->id,
            'total_items' => 1,
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

    private function storedIntent(): ?CheckoutIntent
    {
        return $this->cart->fresh()->checkoutIntent();
    }

    private function chooseAtCart(CheckoutIntent $intent): void
    {
        $this->actingAs($this->user)
            ->post(route('checkout.intent'), ['intent' => $intent->value])
            ->assertRedirect(route('shipping'));
    }

    public function test_each_cart_button_starts_its_own_path(): void
    {
        $this->chooseAtCart(CheckoutIntent::Order);
        $this->assertSame(CheckoutIntent::Order, $this->storedIntent());

        $this->chooseAtCart(CheckoutIntent::Quote);
        $this->assertSame(CheckoutIntent::Quote, $this->storedIntent());
    }

    public function test_an_unknown_choice_is_rejected(): void
    {
        $this->actingAs($this->user)
            ->post(route('checkout.intent'), ['intent' => 'invoice'])
            ->assertSessionHasErrors('intent');

        $this->assertNull($this->storedIntent());
    }

    public function test_the_flow_cannot_start_without_a_choice(): void
    {
        $this->actingAs($this->user)->get(route('shipping'))->assertRedirect(route('cart'));
        $this->actingAs($this->user)->get(route('payment'))->assertRedirect(route('cart'));
        $this->actingAs($this->user)->get(route('checkout.continue'))->assertRedirect(route('cart'));
    }

    public function test_the_flow_cannot_start_with_an_empty_cart(): void
    {
        CartItem::where('cart_id', $this->cart->id)->delete();

        $this->actingAs($this->user)
            ->post(route('checkout.intent'), ['intent' => CheckoutIntent::Order->value])
            ->assertRedirect(route('cart'));

        $this->assertNull($this->storedIntent());
    }

    public function test_a_quote_maker_can_never_reach_the_order_review(): void
    {
        $this->chooseAtCart(CheckoutIntent::Quote);

        $this->actingAs($this->user)->get(route('checkout'))->assertRedirect(route('quote'));
    }

    public function test_an_order_maker_is_kept_off_the_quote_review(): void
    {
        $this->chooseAtCart(CheckoutIntent::Order);

        $this->actingAs($this->user)->get(route('quote'))->assertRedirect(route('checkout'));
    }

    public function test_the_payment_step_branches_on_the_choice(): void
    {
        $this->chooseAtCart(CheckoutIntent::Order);
        $this->actingAs($this->user)->get(route('checkout.continue'))->assertRedirect(route('checkout'));

        $this->chooseAtCart(CheckoutIntent::Quote);
        $this->actingAs($this->user)->get(route('checkout.continue'))->assertRedirect(route('quote'));
    }

    public function test_save_as_a_quote_instead_switches_the_path_and_keeps_the_cart(): void
    {
        $this->chooseAtCart(CheckoutIntent::Order);
        $itemsBefore = CartItem::where('cart_id', $this->cart->id)->count();

        $this->actingAs($this->user)
            ->post(route('checkout.intent.switch'), ['intent' => CheckoutIntent::Quote->value])
            ->assertRedirect(route('quote'));

        $this->assertSame(CheckoutIntent::Quote, $this->storedIntent());
        $this->assertSame($itemsBefore, CartItem::where('cart_id', $this->cart->id)->count());
    }

    public function test_the_choice_survives_further_requests(): void
    {
        $this->chooseAtCart(CheckoutIntent::Quote);

        // A fresh request with no shared session still resolves the same path,
        // which is what makes refresh and browser back/forward safe.
        $this->actingAs($this->user)->get(route('checkout.continue'))->assertRedirect(route('quote'));
        $this->assertSame(CheckoutIntent::Quote, $this->storedIntent());
    }

    public function test_a_quote_only_account_cannot_start_the_order_path(): void
    {
        $this->user->revokePermissionTo('placeOrders');

        $this->actingAs($this->user)
            ->post(route('checkout.intent'), ['intent' => CheckoutIntent::Order->value])
            ->assertRedirect(route('cart'))
            ->assertSessionHas('error');

        $this->assertNull($this->storedIntent());

        $this->chooseAtCart(CheckoutIntent::Quote);
        $this->assertSame(CheckoutIntent::Quote, $this->storedIntent());
    }

    public function test_an_order_cannot_be_placed_from_the_quote_path(): void
    {
        $this->chooseAtCart(CheckoutIntent::Quote);

        $this->actingAs($this->user)
            ->post(route('confirm-order'), ['cart_id' => $this->cart->id])
            ->assertRedirect(route('quote'));
    }
}
