<?php

namespace Tests\Feature;

use App\Http\Controllers\Quote\QuoteController;
use App\Models\EmergencyModeSetting;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class OrderQuoteLookupTest extends TestCase
{
    private const CUSTOMER_A = 'LOOKUP-CUSTOMER-A';

    private const CUSTOMER_B = 'LOOKUP-CUSTOMER-B';

    private ?User $user = null;

    protected function setUp(): void
    {
        parent::setUp();

        EmergencyModeSetting::current()->forceFill(['is_enabled' => false])->save();

        $this->user = User::create([
            'name' => 'Lookup Test User',
            'email' => 'lookup-'.Str::random(12).'@example.test',
            'password' => bcrypt(Str::random(16)),
        ]);
        $this->user->forceFill(['email_verified_at' => now()])->save();

        foreach (['orderHistory' => 'orders', 'getQuotes' => 'quotes'] as $permission => $group) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web'], ['group' => $group]);
            $this->user->givePermissionTo($permission);
        }
    }

    protected function tearDown(): void
    {
        Order::query()
            ->whereIn('customer_number', [self::CUSTOMER_A, self::CUSTOMER_B])
            ->each(function (Order $order) {
                $order->orderItem()->delete();
                $order->forceDelete();
            });

        if ($this->user) {
            $this->user->syncPermissions([]);
            $this->user->forceDelete();
        }

        parent::tearDown();
    }

    public function test_order_lookup_search_by_date_range_does_not_return_other_accounts(): void
    {
        $sharedPo = '200999858';

        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => '000000000648347',
            'customer_po_number' => $sharedPo,
            'customer_number' => self::CUSTOMER_A,
            'status' => '1',
            'created_at' => now()->subDays(3),
        ]);

        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => '000000000699999',
            'customer_po_number' => $sharedPo,
            'customer_number' => self::CUSTOMER_B,
            'status' => null,
            'created_at' => now()->subDays(3),
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->post(route('order-search'), [
                'start_date' => now()->subDays(7)->format('m/d/Y'),
                'end_date' => now()->format('m/d/Y'),
            ]);

        $response->assertOk();
        $response->assertSee('000000000648347');
        $response->assertDontSee('000000000699999');
    }

    public function test_quote_lookup_search_does_not_return_other_accounts_by_bp_number(): void
    {
        $sharedBp = 'BP-SHARED-123';

        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => 'Q-A-'.Str::upper(Str::random(6)),
            'bp_number' => $sharedBp,
            'customer_number' => self::CUSTOMER_A,
            'status' => 'F',
            'created_at' => now()->subDays(5),
        ]);

        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => 'Q-B-'.Str::upper(Str::random(6)),
            'bp_number' => $sharedBp,
            'customer_number' => self::CUSTOMER_B,
            'status' => 'F',
            'created_at' => now()->subDays(5),
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->post(route('quote-search'), [
                'search_input' => $sharedBp,
            ]);

        $response->assertOk();
        $response->assertSee('Q-A-');
        $response->assertDontSee('Q-B-');
    }

    public function test_quote_lookup_excludes_quotes_older_than_ninety_days(): void
    {
        $recentQuoteNo = 'Q-RECENT-'.Str::upper(Str::random(4));
        $oldQuoteNo = 'Q-OLD-'.Str::upper(Str::random(4));

        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => $recentQuoteNo,
            'customer_number' => self::CUSTOMER_A,
            'status' => 'F',
            'created_at' => now()->subDays(30),
        ]);

        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => $oldQuoteNo,
            'customer_number' => self::CUSTOMER_A,
            'status' => 'F',
            'created_at' => now()->subDays(QuoteController::QUOTE_VALID_DAYS + 5),
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->get(route('quotes'));

        $response->assertOk();
        $response->assertSee($recentQuoteNo);
        $response->assertDontSee($oldQuoteNo);
    }

    public function test_lookup_search_toolbars_use_shared_labels_and_no_bulk_download(): void
    {
        $orders = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->get(route('order'));

        $orders->assertOk();
        $orders->assertSee('Search Orders');
        $orders->assertSee('Sync Orders');
        $orders->assertSee('Clear Search');
        $orders->assertDontSee('name="download"');

        $quotes = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->get(route('quotes'));

        $quotes->assertOk();
        $quotes->assertSee('Search Quotes');
        $quotes->assertSee('Sync Quotes');
        $quotes->assertDontSee('name="download"');
    }

    public function test_order_lookup_shows_per_row_download_action(): void
    {
        Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => '000000000611111',
            'customer_number' => self::CUSTOMER_A,
            'status' => '1',
            'created_at' => now()->subDay(),
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->get(route('order'));

        $response->assertOk();
        $response->assertSee('fa-download', false);
        $response->assertSee('Download order confirmation', false);
    }

    public function test_order_receipt_download_does_not_error_without_session_customer_details(): void
    {
        $product = \App\Models\Product::create([
            'name' => 'Receipt Download Test Product',
            'sku' => 'RD-'.Str::upper(Str::random(6)),
            'price' => 10,
            'msrp' => 20,
        ]);

        $order = Order::create([
            'user_id' => $this->user->id,
            'purchase_order_no' => '000000000622222',
            'customer_number' => self::CUSTOMER_A,
            'status' => '1',
            'created_at' => now()->subDay(),
        ]);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'sku' => $product->sku,
            'price' => 10,
            'quantity' => 1,
            'discount_price' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->withSession(['customer_id' => self::CUSTOMER_A])
            ->post(route('receipt-download'), [
                'order_id' => $order->id,
            ]);

        $response->assertOk();
    }
}
