<?php

namespace App\Services;

use App\Enums\CheckoutIntent;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * Single source of truth for the dealer's "order or quote" choice.
 *
 * The choice is stored on the cart row rather than in the session so that it
 * survives a refresh, browser back/forward, a second tab and a session timeout,
 * and disappears automatically whenever the cart itself is cleared.
 */
class CheckoutIntentService
{
    /**
     * The cart the checkout flow is currently operating on.
     *
     * Reads the collection and takes the first row so this always resolves to
     * the same cart the rest of the application uses via `$cart[0]`.
     */
    public function activeCart(?int $userId = null): ?Cart
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return null;
        }

        return Cart::where('user_id', $userId)->get()->first();
    }

    /**
     * The choice stored on the given cart, or on the active cart when omitted.
     */
    public function current(?Cart $cart = null): ?CheckoutIntent
    {
        $cart = $cart ?? $this->activeCart();

        return $cart?->checkoutIntent();
    }

    /**
     * Persist the choice. Writes only when it actually changes so an unchanged
     * intent does not bump `updated_at` on every step of the flow.
     */
    public function remember(Cart $cart, CheckoutIntent $intent): void
    {
        if ($cart->checkoutIntent() === $intent) {
            return;
        }

        $cart->forceFill(['checkout_intent' => $intent->value])->save();
    }

    /**
     * Drop the choice so the dealer is sent back to the cart to choose again.
     */
    public function forget(?Cart $cart = null): void
    {
        $cart = $cart ?? $this->activeCart();

        if ($cart === null || $cart->checkout_intent === null) {
            return;
        }

        $cart->forceFill(['checkout_intent' => null])->save();
    }

    /**
     * Whether the active account is allowed to follow this path.
     */
    public function allows(CheckoutIntent $intent): bool
    {
        return $this->customerHasPermission($intent->permission());
    }

    /**
     * Paths offered to the active account, in cart button order.
     *
     * A quote-only account (holds `getQuotes` but not `placeOrders`) gets the
     * quote path only, and the order path is not reachable at all.
     *
     * @return array<int, CheckoutIntent>
     */
    public function available(): array
    {
        return array_values(array_filter(
            [CheckoutIntent::Quote, CheckoutIntent::Order],
            fn (CheckoutIntent $intent) => $this->allows($intent)
        ));
    }

    /**
     * Resolve the permission against the active AssociateCustomer, falling back
     * to the user, exactly as the rest of the portal does.
     */
    private function customerHasPermission(string $permission): bool
    {
        $customer = getCustomer();

        if ($customer === null) {
            return false;
        }

        try {
            return (bool) $customer->hasPermissionTo($permission);
        } catch (PermissionDoesNotExist $e) {
            // The portal cannot gate on a permission it does not define. Keep
            // today's behaviour (path offered) and let the terminal action be
            // the enforcement point, rather than hiding it from every dealer.
            Log::warning('Checkout intent: permission is not defined, gating skipped.', [
                'permission' => $permission,
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Checkout intent: permission check failed.', [
                'permission' => $permission,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
