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
 * Covers the quote variant of the completion screen: what a dealer lands on after
 * saving a quote, and who is allowed to revisit it.
 *
 * Creates and removes its own account, product and quote, so it is safe to run
 * against a populated database.
 */
class QuoteCompletionTest extends TestCase
{
    private const CUSTOMER_NUMBER = 'QC-TEST-CUSTOMER';

    private ?User $user = null;

    private ?Product $product = null;

    private ?Order $quote = null;

    protected function setUp(): void
    {
        parent::setUp();

        EmergencyModeSetting::current()->forceFill(['is_enabled' => false])->save();

        $this->product = Product::create([
            'name' => 'Quote Completion Test Product',
            'sku' => 'QC-TEST-'.Str::random(6),
            'price' => 10,
            'msrp' => 20,
        ]);

        $this->user = User::create([
            'name' => 'Quote Completion Test',
            'email' => 'quote-complete-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        // The shared nav gates links on these, and Spatie throws rather than
        // returning false when a permission is not defined at all.
        $permissionGroups = [
            'orderHistory' => 'orders',
            'placeOrders' => 'orders',
            'getQuotes' => 'quotes',
            'accessVault' => 'vault',
        ];

        foreach ($permissionGroups as $permission => $group) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'], ['group' => $group]);
            $this->user->givePermissionTo($permission);
        }

        $this->quote = Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => 'Q'.Str::upper(Str::random(8)),
            'total_items' => 2,
            'customer_number' => self::CUSTOMER_NUMBER,
        ]);
        $this->quote->forceFill(['status' => 'F', 'total' => 20])->save();

        OrderItem::create([
            'order_id' => $this->quote->id,
            'product_id' => $this->product->id,
            'sku' => $this->product->sku,
            'price' => 10,
            'quantity' => 2,
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

    public function test_it_shows_the_quote_number_and_expiry(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id));

        $response->assertOk();
        $response->assertSee('Your Quote Is Saved');
        $response->assertSee($this->quote->purchase_order_no);
        $response->assertSee($this->quote->created_at->copy()->addDays(90)->format('F j, Y'));
    }

    public function test_it_offers_one_download_control_for_every_pricing_tier(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id));

        $response->assertOk();
        $response->assertSee(route('pdf-download-quote', $this->quote->id));

        foreach (['all_price', 'msrp_primary', 'msrp_only'] as $tier) {
            $response->assertSee($tier);
        }
    }

    public function test_the_quote_path_is_shown_in_the_step_bar(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id));

        $response->assertOk();
        $response->assertSee('Quote Complete');
        $response->assertDontSee('Order Complete');
        $response->assertDontSee('Confirm Order');
    }

    public function test_a_quote_from_another_customer_account_is_not_readable(): void
    {
        $this->actingAs($this->user)
            ->withSession(['customer_id' => 'SOME-OTHER-CUSTOMER'])
            ->get(route('quote.complete', $this->quote->id))
            ->assertForbidden();
    }

    public function test_it_offers_convert_to_order_when_the_account_can_place_orders(): void
    {
        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id));

        $response->assertOk();
        $response->assertSee('Convert to order');
        $response->assertSee(route('place-order-from-quote', $this->quote->id), false);
    }

    public function test_it_hides_convert_to_order_for_quote_only_accounts(): void
    {
        $this->user->revokePermissionTo('placeOrders');

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id));

        $response->assertOk();
        $response->assertDontSee('Convert to order');
    }

    public function test_revisiting_the_completion_url_still_works(): void
    {
        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id))
            ->assertOk();

        $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_NUMBER])
            ->get(route('quote.complete', $this->quote->id))
            ->assertOk()
            ->assertSee($this->quote->purchase_order_no);
    }
}
