<?php

namespace Tests\Feature;

use App\Models\EmergencyModeSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

/**
 * Covers the order completion screen reached after Place Order / Confirm Order.
 */
class OrderCompletionTest extends TestCase
{
    private const CUSTOMER_NUMBER = 'OC-TEST-CUSTOMER';

    private ?User $user = null;

    private ?Product $product = null;

    private ?Order $order = null;

    protected function setUp(): void
    {
        parent::setUp();

        EmergencyModeSetting::current()->forceFill(['is_enabled' => false])->save();

        $this->product = Product::create([
            'name' => 'Order Completion Test Product',
            'sku' => 'OC-TEST-'.Str::random(6),
            'price' => 10,
            'msrp' => 20,
        ]);

        $this->user = User::create([
            'name' => 'Order Completion Test',
            'email' => 'order-complete-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        foreach (['orderHistory' => 'orders', 'placeOrders' => 'orders', 'accessVault' => 'vault'] as $permission => $group) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'], ['group' => $group]);
            $this->user->givePermissionTo($permission);
        }

        $this->order = Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => 'O'.Str::upper(Str::random(8)),
            'customer_po_number' => 'PO-TEST-1',
            'total_items' => 1,
            'customer_number' => self::CUSTOMER_NUMBER,
        ]);
        $this->order->forceFill(['status' => '1', 'total' => 10])->save();

        OrderItem::create([
            'order_id' => $this->order->id,
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
        if ($this->order) {
            OrderItem::where('order_id', $this->order->id)->delete();
            $this->order->forceDelete();
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

    public function test_it_shows_the_order_number_and_thank_you_message(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id));

        $response->assertOk();
        $response->assertSee('Thank You For Your Purchase');
        $response->assertSee($this->order->purchase_order_no);
        $response->assertSee($this->order->customer_po_number);
    }

    public function test_the_order_path_is_shown_in_the_step_bar(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id));

        $response->assertOk();
        $response->assertSee('Order Complete');
        $response->assertDontSee('Quote Complete');
    }

    public function test_an_order_from_another_customer_account_is_not_readable(): void
    {
        $this->actingAs($this->user)
            ->withSession(['customer_id' => 'SOME-OTHER-CUSTOMER'])
            ->get(route('order.complete', $this->order->id))
            ->assertForbidden();
    }

    public function test_it_shows_the_order_status_chip(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id));

        $response->assertOk();
        $response->assertSee('Open Order');
    }

    public function test_it_offers_a_track_this_order_link(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id));

        $response->assertOk();
        $response->assertSee('Track this order');
        $response->assertSee(route('order', ['search_input' => $this->order->purchase_order_no]), false);
    }

    public function test_it_shows_converted_from_quote_note_when_lineage_exists(): void
    {
        $this->order->update(['converted_from_quote_no' => 'Q-SOURCE-123']);

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id));

        $response->assertOk();
        $response->assertSee('converted from quote');
        $response->assertSee('Q-SOURCE-123');
    }

    public function test_revisiting_the_completion_url_still_works(): void
    {
        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id))
            ->assertOk();

        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('order.complete', $this->order->id))
            ->assertOk()
            ->assertSee($this->order->purchase_order_no);
    }
}
