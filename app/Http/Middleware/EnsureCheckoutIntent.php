<?php

namespace App\Http\Middleware;

use App\Enums\CheckoutIntent;
use App\Models\EmergencyModeSetting;
use App\Services\CheckoutIntentService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Keeps every checkout screen on the path the dealer chose at the cart.
 *
 * Applied without a parameter the screen is shared by both paths and only needs
 * a choice to exist. Applied as `checkout.intent:order` or `checkout.intent:quote`
 * the screen belongs to one path, and anyone on the other path is redirected to
 * their own review screen instead — which is what makes the wrong terminal
 * action unreachable by URL, bookmark or browser back/forward.
 */
class EnsureCheckoutIntent
{
    public function __construct(private readonly CheckoutIntentService $intents)
    {
    }

    public function handle(Request $request, Closure $next, ?string $expected = null): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        // Checked first so a paused portal explains itself rather than asking the
        // dealer to make a choice they cannot act on.
        if (EmergencyModeSetting::current()->is_enabled) {
            return $this->backToCart(emergencyModeMessage());
        }

        $cart = $this->intents->activeCart();

        if ($cart === null || !$cart->hasItems()) {
            // A finished flow has no cart left. Send the dealer to what they just
            // created rather than to an empty cart that reads like a failure.
            $completed = $this->intents->completedUrl();

            if ($completed !== null) {
                return redirect()->to($completed);
            }

            return $this->backToCart('Your cart is empty. Add an item before continuing.');
        }

        // A cart with items means a new flow, so the previous completion is no
        // longer where the dealer belongs.
        $this->intents->forgetCompleted();

        $intent = $this->intents->current($cart);

        if ($intent === null) {
            return $this->backToCart('Please choose "Place Order" or "Save as Quote" to continue.');
        }

        // Permissions can change mid-flow, for example after switching account.
        if (!$this->intents->allows($intent)) {
            $this->intents->forget($cart);

            return $this->backToCart('Please choose how you would like to continue.');
        }

        $expectedIntent = CheckoutIntent::fromNullable($expected);

        if ($expectedIntent !== null && $expectedIntent !== $intent) {
            return redirect()->route($intent->reviewRouteName());
        }

        return $this->withoutStoring($next($request));
    }

    private function backToCart(string $message): Response
    {
        return redirect()->route('cart')->with('error', $message);
    }

    /**
     * Checkout screens are choice-dependent, so they must never be replayed from
     * the browser cache with the buttons of the other path.
     */
    private function withoutStoring(Response $response): Response
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }
}
