<?php

namespace Tests\Feature;

use App\Enums\CheckoutIntent;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\EmergencyModeSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\QuoteConvertService;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ConvertQuoteToOrderTest extends TestCase
{
    private const CUSTOMER_NUMBER = 'CQ-TEST-CUSTOMER';

    private ?User $user = null;

    private ?Product $product = null;

    private ?Order $quote = null;

    protected function setUp(): void
    {
        parent::setUp();

        EmergencyModeSetting::current()->forceFill(['is_enabled' => false])->save();

        $this->product = Product::create([
            'name' => 'Convert Quote Test Product',
            'sku' => 'CQ-TEST-'.Str::random(6),
            'price' => 10,
            'msrp' => 20,
        ]);

        $this->user = User::create([
            'name' => 'Convert Quote Test',
            'email' => 'convert-quote-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        foreach (['placeOrders' => 'orders', 'getQuotes' => 'quotes'] as $permission => $group) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'], ['group' => $group]);
            $this->user->givePermissionTo($permission);
        }

        $this->quote = Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => 'Q'.Str::upper(Str::random(8)),
            'total_items' => 1,
            'customer_number' => self::CUSTOMER_NUMBER,
        ]);
        $this->quote->forceFill(['status' => 'F', 'total' => 10])->save();

        OrderItem::create([
            'order_id' => $this->quote->id,
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
        if ($this->quote) {
            OrderItem::where('order_id', $this->quote->id)->delete();
            $this->quote->forceDelete();
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

    public function test_quotes_list_shows_convert_to_order_and_single_pdf_control(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quotes'));

        $response->assertOk();
        $response->assertSee('Convert to order');
        $response->assertDontSee('Download MSRP and Primary Price');
        $response->assertSee('Download PDF');
        $response->assertSee(route('place-order-from-quote', $this->quote->id), false);
    }

    public function test_order_review_shows_converting_quote_banner_when_session_is_set(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'total_items' => 1,
            'checkout_intent' => CheckoutIntent::Order->value,
        ]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
            'sku' => $this->product->sku,
            'price' => 10,
            'quantity' => 1,
            'msrp' => 20,
            'discount' => 0,
            'discount_price' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->withSession([
                'customer_id' => self::CUSTOMER_NUMBER,
                QuoteConvertService::SESSION_QUOTE_PURCHASE_ORDER_NO => $this->quote->purchase_order_no,
            ])
            ->get(route('checkout'));

        $response->assertOk();
        $response->assertSee('Converting quote');
        $response->assertSee($this->quote->purchase_order_no);

        CartItem::where('cart_id', $cart->id)->delete();
        Cart::where('id', $cart->id)->delete();
    }

    public function test_convert_is_blocked_for_quote_only_accounts(): void
    {
        $this->user->revokePermissionTo('placeOrders');

        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('place-order-from-quote', $this->quote->id))
            ->assertRedirect(route('quotes'))
            ->assertSessionHas('error');
    }

    public function test_convert_is_blocked_when_quote_is_no_longer_forward(): void
    {
        $this->quote->update(['status' => '1']);

        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('place-order-from-quote', $this->quote->id))
            ->assertRedirect(route('quotes'))
            ->assertSessionHas('error');
    }

    public function test_convert_is_blocked_when_quote_is_expired(): void
    {
        $this->quote->forceFill(['created_at' => now()->subDays(91)])->save();

        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('place-order-from-quote', $this->quote->id))
            ->assertRedirect(route('quotes'))
            ->assertSessionHas('error');
    }

    public function test_switching_to_quote_review_clears_convert_session(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'total_items' => 1,
            'checkout_intent' => CheckoutIntent::Order->value,
        ]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
            'sku' => $this->product->sku,
            'price' => 10,
            'quantity' => 1,
            'msrp' => 20,
            'discount' => 0,
            'discount_price' => 10,
        ]);

        $this->actingAs($this->user)
            ->withSession([
                'customer_id' => self::CUSTOMER_NUMBER,
                QuoteConvertService::SESSION_QUOTE_ID => $this->quote->id,
                QuoteConvertService::SESSION_QUOTE_PURCHASE_ORDER_NO => $this->quote->purchase_order_no,
            ])
            ->post(route('checkout.intent.switch'), ['intent' => CheckoutIntent::Quote->value])
            ->assertSessionMissing(QuoteConvertService::SESSION_QUOTE_PURCHASE_ORDER_NO);

        CartItem::where('cart_id', $cart->id)->delete();
        Cart::where('id', $cart->id)->delete();
    }
}
