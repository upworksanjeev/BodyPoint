<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SysproService;
use Carbon\Carbon;

class SyncSixMonthOrderHistory extends Command
{
    protected $signature = 'sync:six-month-order-history {customer?}';
    protected $description = 'Sync last 6 months order history from Syspro API (runs every 5 minutes)';

    public function handle()
    {
        $cronName = 'sync:six-month-order-history';
        Log::info("[$cronName] Sync started");

        $customer = $this->argument('customer') ?? null;
        $endDate = now()->endOfDay();

        $progressFile = storage_path('app/order-history-sync.json');
        $lastSynced = file_exists($progressFile)
            ? json_decode(file_get_contents($progressFile), true)['last_synced'] ?? now()->subMonths(6)->startOfDay()->toIso8601String()
            : now()->subMonths(6)->startOfDay()->toIso8601String();

        $currentFrom = Carbon::parse($lastSynced);

        if ($currentFrom >= $endDate) {
            Log::info("[$cronName] 6-month sync already complete. Skipping.");
            return;
        }

        $currentTo = $currentFrom->copy()->addDays(15);
        if ($currentTo > $endDate) {
            $currentTo = $endDate;
        }

        $dateFrom = $currentFrom->copy()->startOfDay()->toIso8601String();
        $dateTo = $currentTo->copy()->endOfDay()->toIso8601String();

        try {
            Log::info("[$cronName] Fetching orders from $dateFrom to $dateTo for customer $customer");

            $response = SysproService::orderHistory('OrderHistory', $dateTo, $dateFrom, $customer);

            if (!isset($response['response']) || empty($response['response'])) {
                Log::info("[$cronName] No orders found between $dateFrom and $dateTo");
            } else {
                $this->storeOrders($response['response'], $cronName);
                Log::info("[$cronName] Orders stored between $dateFrom and $dateTo");
            }

            file_put_contents($progressFile, json_encode(['last_synced' => $currentTo->toIso8601String()]));
        } catch (\Exception $e) {
            Log::error("[$cronName] Error: " . $e->getMessage());
        }

        Log::info("[$cronName] Sync step completed");
    }

    protected function storeOrders($orders, $cronName)
    {
        foreach ($orders as $orderData) {
            try {
                $lineItems = $orderData['Line'] ?? [];
                $orderFromWebsite = $orderData['OrderFromWebsite'] ?? false;

                $totalDiscounted = collect($lineItems)->sum(function ($line) use ($orderFromWebsite) {
                    $qty = $line['Qty'] ?? 1;
                    $dealerPrice = $line['DealerPrice'] ?? 0;
                    $price = $line['Price'] ?? 0;
                    $discountPercent = $line['DiscPct'] ?? 0;

                    if ($orderFromWebsite || ($discountPercent == 0.00)) {
                        return round($price * $qty, 3);
                    } else {
                        $discount = ($discountPercent * $dealerPrice) / 100;
                        $discountedPrice = round($dealerPrice - $discount, 3);
                        return round($discountedPrice * $qty, 3);
                    }
                });

                $order = Order::updateOrCreate(
                    ['purchase_order_no' => $orderData['OrderNumber']],
                    [
                        'customer_number'       => $orderData['Customer'] ?? null,
                        'customer_po_number'    => $orderData['CustomerPONumber'] ?? null,
                        'purchase_order_no'     => $orderData['OrderNumber'] ?? null,
                        'status'                => $orderData['Status'] ?? null,
                        'associate_customer_id' => null,
                        'total_items'           => count($lineItems),
                        'total'                 => $totalDiscounted,
                        'OrderFromWebsite'      => $orderFromWebsite ? 1 : 0,
                        'created_at' => !empty($orderData['OrderDate'])
                            ? Carbon::parse($orderData['OrderDate'])->startOfDay()->format('Y-m-d H:i:s')
                            : now(),
                    ]
                );

                Log::info("[$cronName] Processed Order: {$order->purchase_order_no}");

                $order->orderItem()->delete();

                foreach ($lineItems as $lineItem) {
                    try {
                        $sku = $lineItem['StockCode'];
                        $dealerPrice = $lineItem['DealerPrice'] ?? 0;
                        $price = $lineItem['Price'] ?? 0;
                        $discountPercent = $lineItem['DiscPct'] ?? 0;
                        $qty = $lineItem['Qty'] ?? 1;

                        if ($orderFromWebsite || ($discountPercent == 0.00)) {
                            $calculated = [
                                'price' => round($dealerPrice, 3), // always store original dealer price here
                                'discounted_price' => round($price, 3), // store discounted price from JSON
                                'discount' => round($dealerPrice - $price, 3),
                            ];
                        } else {
                            $discount = ($discountPercent * $dealerPrice) / 100;
                            $discountedPrice = round($dealerPrice - $discount, 3);
                            $calculated = [
                                'price' => round($dealerPrice, 3),
                                'discounted_price' => $discountedPrice,
                                'discount' => round($discount, 3),
                            ];
                        }

                        $product = Product::with(['variation' => function ($query) use ($sku) {
                            $query->where('sku', $sku);
                        }])
                            ->where('sku', $sku)
                            ->orWhereHas('variation', function ($query) use ($sku) {
                                $query->where('sku', $sku);
                            })
                            ->first();

                        OrderItem::create([
                            'order_id'       => $order->id,
                            'sku'            => $sku ?? null,
                            'price'          => $calculated['price'], // store dealer price
                            'quantity'       => $qty,
                            'line_number'    => $lineItem['SalesOrderLine'] ?? null,
                            'marked_for'     => $lineItem['MakeForLine'] ?? null,
                            'discount'       => $calculated['discount'],
                            'discount_price' => $calculated['discounted_price'], // store final discounted price
                            'product_id'     => $product?->id,
                            'variation_id'   => $product?->variation?->first()?->id,
                            'msrp'           => $lineItem['MSRPPrice'] ?? 0,
                        ]);

                        Log::info("[$cronName] Stored item: $sku");
                    } catch (\Exception $e) {
                        Log::error("[$cronName] Error storing line item (SKU: {$lineItem['StockCode']}): " . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                Log::error("[$cronName] Error storing order ({$orderData['OrderNumber']}): " . $e->getMessage());
            }
        }
    }
}
