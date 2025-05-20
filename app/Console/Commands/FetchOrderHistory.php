<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SysproService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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

                // Delete previous items
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

                        $productId = $product?->id;
                        $variationId = $product?->variation?->first()?->id;

                        if (!$product) {
                            Log::warning("[$cronName] No product found for SKU: $sku");
                        }

                        OrderItem::create([
                            'order_id'       => $order->id,
                            'sku'            => $sku ?? null,
                            'price'          => $lineItem['Price'] ?? 0,
                            'quantity'       => $lineItem['Qty'] ?? 0,
                            'line_number'    => $lineItem['SalesOrderLine'] ?? null,
                            'marked_for'     => null,
                            'discount'       => 0,
                            'discount_price' => 0,
                            'product_id'     => $productId,
                            'variation_id'   => $variationId,
                            'msrp'           => $lineItem['Price'] ?? 0,
                        ]);

                        Log::info("[$cronName] OrderItem created for SKU: $sku");
                    } catch (\Exception $e) {
                        Log::info("[$cronName] Processed Order: {$order->purchase_order_no}");
                        Log::error("[$cronName] Failed to process order line SKU: {$lineItem['StockCode']} - " . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                Log::error("[$cronName] Failed to process order: {$orderData['OrderNumber']} - " . $e->getMessage());
            }
        }
    }
}
