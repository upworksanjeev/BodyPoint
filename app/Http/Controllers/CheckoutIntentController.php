<?php

namespace App\Http\Controllers;

use App\Enums\CheckoutIntent;
use App\Models\Cart;
use App\Models\EmergencyModeSetting;
use App\Services\CheckoutIntentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Owns the dealer's order-or-quote choice: taken at the cart, switched mid-flow,
 * and used to branch after the payment step.
 */
class CheckoutIntentController extends Controller
{
    public function __construct(private readonly CheckoutIntentService $intents)
    {
    }

    /**
     * Cart entry point: record the choice and start the checkout flow.
     */
    public function store(Request $request): RedirectResponse
    {
        $intent = $this->requestedIntent($request);
        $cart = $this->usableCart();

        if ($cart instanceof RedirectResponse) {
            return $cart;
        }

        if (!$this->intents->allows($intent)) {
            return redirect()->route('cart')->with('error', $this->deniedMessage($intent));
        }

        $this->intents->remember($cart, $intent);

        return redirect()->route('shipping');
    }

    /**
     * Mid-flow switch, used by "Save as a quote instead" on the order review.
     *
     * Only the stored choice changes: the cart, the selected shipping address
     * and the selected payment details are all untouched, so the dealer lands on
     * the quote review with nothing to re-enter.
     */
    public function swap(Request $request): RedirectResponse
    {
        $intent = $this->requestedIntent($request);
        $cart = $this->usableCart();

        if ($cart instanceof RedirectResponse) {
            return $cart;
        }

        if (!$this->intents->allows($intent)) {
            return redirect()
                ->route($this->intents->current($cart)?->reviewRouteName() ?? 'cart')
                ->with('error', $this->deniedMessage($intent));
        }

        $this->intents->remember($cart, $intent);

        return redirect()->route($intent->reviewRouteName());
    }

    /**
     * Payment step "Next": continue to the review screen for the stored choice.
     *
     * Resolved on the server so a cached page can never send an order down the
     * quote path, or the other way round.
     */
    public function proceed(): RedirectResponse
    {
        $cart = $this->usableCart();

        if ($cart instanceof RedirectResponse) {
            return $cart;
        }

        $intent = $this->intents->current($cart);

        if ($intent === null) {
            return redirect()->route('cart')->with('error', $this->chooseAgainMessage());
        }

        if (!$this->intents->allows($intent)) {
            $this->intents->forget($cart);

            return redirect()->route('cart')->with('error', $this->deniedMessage($intent));
        }

        return redirect()->route($intent->reviewRouteName());
    }

    private function requestedIntent(Request $request): CheckoutIntent
    {
        $validated = $request->validate([
            'intent' => ['required', 'string', Rule::in(CheckoutIntent::values())],
        ], [
            'intent.required' => 'Please choose whether you are placing an order or saving a quote.',
            'intent.in' => 'Please choose whether you are placing an order or saving a quote.',
        ]);

        // Safe by validation; fromNullable keeps this from throwing regardless.
        return CheckoutIntent::fromNullable($validated['intent']) ?? CheckoutIntent::Quote;
    }

    /**
     * @return Cart|RedirectResponse
     */
    private function usableCart()
    {
        if (EmergencyModeSetting::current()->is_enabled) {
            return redirect()->route('cart')->with('error', emergencyModeMessage());
        }

        $cart = $this->intents->activeCart();

        if ($cart === null || !$cart->hasItems()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add an item before continuing.');
        }

        return $cart;
    }

    private function deniedMessage(CheckoutIntent $intent): string
    {
        return $intent->isOrder()
            ? 'Your account is not set up to place orders online. You can save this as a quote instead.'
            : 'Your account is not set up to save quotes online.';
    }

    private function chooseAgainMessage(): string
    {
        return 'Please choose "Place Order" or "Save as Quote" to continue.';
    }
}
