<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SysproService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FetchOrderHistory extends Command
{
    protected $signature = 'fetch:order-history {customer?}';
    protected $description = 'Fetch order history from external API';

    public function handle()
    {
        $cronName = 'fetch:order-history';
        Log::info("[$cronName] Cron started");

        $url = 'OrderHistory';
        $dateFrom = now()->subHours(24)->toIso8601String();
        $dateTo   = now()->endOfDay()->toIso8601String();

        $customer = $this->argument('customer') ?? null;

        try {
            Log::info("[$cronName] Sending request to SysproService from $dateFrom to $dateTo for customer $customer");

            $response = SysproService::orderHistory($url, $dateTo, $dateFrom, $customer);

            if (!isset($response['response']) || empty($response['response'])) {
                Log::warning("[$cronName] No orders found in response.");
                return;
            }

            $this->storeOrders($response['response'], $cronName);
            Log::info("[$cronName] Cron finished successfully");
        } catch (\Exception $e) {
            Log::error("[$cronName] Cron failed: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
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

                    if ($orderFromWebsite || $discountPercent == 0.00) {
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

                        if ($orderFromWebsite || $discountPercent == 0.00) {
                            $calculated = [
                                'price' => round($dealerPrice, 3),
                                'discounted_price' => round($price, 3),
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
                            'price'          => $calculated['price'], // dealer price
                            'quantity'       => $qty,
                            'line_number'    => $lineItem['SalesOrderLine'] ?? null,
                            'marked_for'     => $lineItem['MakeForLine'] ?? null,
                            'discount'       => $calculated['discount'],
                            'discount_price' => $calculated['discounted_price'], // final discounted price
                            'product_id'     => $product?->id,
                            'variation_id'   => $product?->variation?->first()?->id,
                            'msrp'           => $lineItem['MSRPPrice'] ?? 0,
                        ]);

                        Log::info("[$cronName] OrderItem created for SKU: $sku");
                    } catch (\Exception $e) {
                        Log::error("[$cronName] Failed to process order line SKU: {$lineItem['StockCode']} - " . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                Log::error("[$cronName] Failed to process order: {$orderData['OrderNumber']} - " . $e->getMessage());
            }
        }
    }
}
