<?php

namespace App\Http\Controllers;

use App\Models\AssociateCustomer;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user()->load(['associateCustomers']);
        $customer = getCustomer();
        $customerNumber = (string) getCustomerId();

        $canPlaceOrders = $this->customerCan($customer, 'placeOrders');
        $canViewOrders = $this->customerCan($customer, 'orderHistory');
        $canViewQuotes = $this->customerCan($customer, 'getQuotes');
        $canAccessVault = $this->customerCan($customer, 'accessVault');
        $canAddToCart = $this->customerCan($customer, 'addToCart');

        return view('dashboard', [
            'firstName' => $this->firstName($user),
            'accountCode' => $customerNumber,
            'accountName' => $this->accountName($user, $customer, $customerNumber),
            'canSwitchAccount' => $this->canSwitchAccount($user),
            'canPlaceOrders' => $canPlaceOrders,
            'canViewOrders' => $canViewOrders,
            'canViewQuotes' => $canViewQuotes,
            'canAccessVault' => $canAccessVault,
            'canAddToCart' => $canAddToCart,
            'recentOrders' => $canViewOrders ? $this->recentOrders($customerNumber) : collect(),
            'openQuotes' => $canViewQuotes ? $this->openQuotes($customerNumber) : collect(),
            'cartSummary' => $this->cartSummary($user->id),
        ]);
    }

    private function recentOrders(string $customerNumber)
    {
        $orders = Order::with([
            'orderItem' => function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('action')
                        ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                })->orderBy('id');
            },
            'orderItem.product',
        ])
            ->where('customer_number', $customerNumber)
            ->where('status', '!=', 'D')
            ->where('status', '!=', 'F')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return $orders->map(function (Order $order) {
            $firstItem = $order->orderItem->first();

            return [
                'id' => $order->id,
                'number' => $order->purchase_order_no ?: $order->bp_number,
                'sku' => $firstItem->sku ?? null,
                'item_name' => $firstItem->product->name ?? ($firstItem->sku ?? 'Order'),
                'status' => $order->order_status,
                'status_code' => (string) $order->status,
            ];
        });
    }

    private function openQuotes(string $customerNumber)
    {
        $lifetimeDays = (int) config('bodypoint.quote_lifetime_days', 90);
        $nearExpiryDays = (int) config('bodypoint.quote_near_expiry_days', 14);
        $cutoff = now()->subDays($lifetimeDays);

        $quotes = Order::with([
            'orderItem' => function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('action')
                        ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                })->orderBy('id');
            },
            'orderItem.product',
        ])
            ->where('customer_number', $customerNumber)
            ->where('status', 'F')
            ->where('created_at', '>=', $cutoff)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return $quotes->map(function (Order $quote) use ($lifetimeDays, $nearExpiryDays) {
            $firstItem = $quote->orderItem->first();
            $createdAt = $quote->created_at instanceof Carbon
                ? $quote->created_at
                : Carbon::parse($quote->created_at);
            $expiresAt = $createdAt->copy()->addDays($lifetimeDays);
            $daysLeft = (int) now()->startOfDay()->diffInDays($expiresAt->copy()->startOfDay(), false);

            if ($daysLeft < 0) {
                return null;
            }

            $nearExpiry = $daysLeft <= $nearExpiryDays;
            if ($daysLeft === 0) {
                $expiryLabel = 'Expires today';
            } elseif ($nearExpiry) {
                $expiryLabel = 'Expires in ' . $daysLeft . ' ' . ($daysLeft === 1 ? 'day' : 'days');
            } else {
                $expiryLabel = $daysLeft . ' days left';
            }

            return [
                'id' => $quote->id,
                'number' => $quote->purchase_order_no ?: $quote->bp_number,
                'sku' => $firstItem->sku ?? null,
                'item_name' => $firstItem->product->name ?? ($firstItem->sku ?? 'Quote'),
                'days_left' => $daysLeft,
                'near_expiry' => $nearExpiry,
                'expiry_label' => $expiryLabel,
            ];
        })->filter()->values();
    }

    private function cartSummary(int $userId): array
    {
        $cart = Cart::with('cartItem')->where('user_id', $userId)->first();
        $items = $cart?->cartItem ?? collect();

        if (!$cart || $items->isEmpty() || (int) $cart->total_items < 1) {
            return [
                'count' => 0,
                'subtotal' => 0,
                'is_empty' => true,
            ];
        }

        $subtotal = $items->sum(function ($item) {
            $unit = ((float) $item->discount_price == 0.0)
                ? (float) $item->price
                : (float) $item->discount_price;

            return $unit * (int) $item->quantity;
        });

        $count = (int) ($cart->total_items ?: $items->sum('quantity'));

        return [
            'count' => $count,
            'subtotal' => $subtotal,
            'is_empty' => $count < 1,
        ];
    }

    private function firstName(Authenticatable $user): string
    {
        if (!empty($user->first_name)) {
            return $user->first_name;
        }

        $name = trim((string) ($user->name ?? ''));

        return $name !== '' ? (string) strtok($name, ' ') : 'there';
    }

    private function accountName(Authenticatable $user, mixed $customer, string $customerNumber): string
    {
        if ($customer instanceof AssociateCustomer) {
            $name = trim((string) ($customer->name ?: trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))));
            if ($name !== '') {
                return $name;
            }
        }

        if ($user instanceof User) {
            $match = $user->associateCustomers->firstWhere('customer_id', $customerNumber);
            if ($match && !empty($match->name)) {
                return $match->name;
            }
        }

        return (string) ($user->name ?? $customerNumber);
    }

    private function canSwitchAccount(Authenticatable $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        $accounts = $user->associateCustomers;
        $hasDefault = $accounts->contains('customer_id', $user->default_customer_id);
        $count = $accounts->count() + ($hasDefault ? 0 : (empty($user->default_customer_id) ? 0 : 1));

        return $count > 1;
    }

    private function customerCan(mixed $customer, string $permission): bool
    {
        if (!$customer) {
            return false;
        }

        try {
            return $customer->hasPermissionTo($permission);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
