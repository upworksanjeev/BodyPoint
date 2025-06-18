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

        if (file_exists($progressFile)) {
            $lastSynced = json_decode(file_get_contents($progressFile), true)['last_synced'] ?? now()->subMonths(6)->startOfDay()->toIso8601String();
            $currentFrom = Carbon::parse($lastSynced);
        } else {
            $currentFrom = now()->subMonths(6)->startOfDay();
        }


        if ($currentFrom >= $endDate) {
            Log::info("[$cronName] 6-month sync already complete. Skipping.");
            return;
        }

        $currentTo = $currentFrom->copy()->addDays(1);
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
            if (Order::where('purchase_order_no', $orderData['OrderNumber'])->exists()) {
                // Log::info("[$cronName] Skipped existing order: {$orderData['OrderNumber']}");
                continue;
            }
            try {
                $order = Order::updateOrCreate(
                    ['purchase_order_no' => $orderData['OrderNumber']],
                    [
                        'customer_number'       => $orderData['Customer'] ?? null,
                        'customer_po_number'    => $orderData['CustomerPONumber'] ?? null,
                        'purchase_order_no'     => $orderData['OrderNumber'] ?? null,
                        'status'                => $orderData['Status'] ?? null,
                        'associate_customer_id' => null,
                        'total_items'           => count($orderData['Line'] ?? []),
                        'total'                 => collect($orderData['Line'])->sum('Price'),
                        'created_at'            => !empty($orderData['OrderDate']) ? date('Y-m-d H:i:s', strtotime($orderData['OrderDate'])) : now(),
                    ]
                );
                Log::info("[$cronName] Processed Order: {$order->purchase_order_no}");
                $order->orderItem()->delete();

                foreach ($orderData['Line'] as $lineItem) {
                    try {
                        $sku = $lineItem['StockCode'];
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
                            'price'          => $lineItem['DealerPrice'] ?? 0,
                            'quantity'       => $lineItem['Qty'] ?? 0,
                            'line_number'    => $lineItem['SalesOrderLine'] ?? null,
                            'marked_for'     => $lineItem['MakeForLine'] ?? null,
                            'discount'       => isset($lineItem['DealerPrice'], $lineItem['Price'])
                                ? ($lineItem['DealerPrice'] - $lineItem['Price'])
                                : 0,
                            'discount_price' => $lineItem['Price'] ?? 0,
                            'product_id'     => $product?->id,
                            'variation_id'   => $product?->variation?->first()?->id,
                            'msrp'           => $lineItem['MSRPPrice'] ?? 0,
                        ]);


                        Log::info("[$cronName] Stored item: $sku");
                    } catch (\Exception $e) {
                        Log::info("[$cronName] Processed Order: {$order->purchase_order_no}");
                        Log::error("[$cronName] Error storing line item (SKU: {$lineItem['StockCode']}): " . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                Log::error("[$cronName] Error storing order ({$orderData['OrderNumber']}): " . $e->getMessage());
            }
        }
    }
}
