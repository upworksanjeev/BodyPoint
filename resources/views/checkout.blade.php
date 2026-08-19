<x-mainpage-layout>
    @section('title', 'Checkout - '.config('app.name', 'Bodypoint'))
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div id="error_alert" x-data="{ open: true }" x-show="open" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert">
        {!! $error !!}
        <input type="hidden" id="error-messages" value='@json($errors->all())'>
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-red-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
    @endforeach
    </div>
    @endif
    <x-cart-nav />

    <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
        <div class="container mx-auto">
            <div class="max-w-screen-xl mx-auto">
                <x-checkout-header page="review" />

                <div class="pb-6">
                    @if (!empty($convertingQuoteNo))
                        <p class="text-[13px] font-normal leading-[19px] text-center mb-2 text-gray-700">
                            Converting quote <span class="font-semibold">{{ $convertingQuoteNo }}</span> to an order.
                        </p>
                    @endif
                    <p class="text-[13px] font-normal leading-[19px] text-center">Your order summary is provided below. Please review carefully and click place order to submit your order. Click cancel to return to your shopping cart.</p>
                </div>

                <div class="card w-full max-w-[920px] m-auto bg-white border border-gray-200 rounded-2xl shadow mb-4">
                    <div class="card-header px-6 py-2 bg-[#00838f] rounded-t-xl">
                        <h4 class="text-[#fff]">Order Information</h4>
                    </div>
                    <div class="card-body p-6">
                        <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                            <li class="flex items-start gap-5">
                                <span class="text-sm text-[#000] font-normal leading-[17px]">Account</span>
                                <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $user->email }}</span>
                            </li>
                        </ul>
                    </div>
                    <x-shipping-info :cart="$cart" :user="$user" :userDetail="$user_detail" :editRoute="route('shipping')" />
                    <x-cart.final-checkout-list :cart="$cart" :editable="true" :hidePoSummary="true" />

                    <form id="confirm-order-form" action="{{ route('confirm-order') }}" method="post">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $cart[0]['id'] ?? '' }}">
                        <input type="hidden" name="selected_credit_card" id="form_credit_card_data" value="{{ $selectedCard['json'] ?? '' }}" />
                        <input type="hidden" name="credit_card_last_four" id="form_credit_card_last_four" value="{{ $selectedCard['last_four'] ?? '' }}" />
                        <input type="hidden" name="credit_card_expiry" id="form_credit_card_expiry" value="{{ $selectedCard['expiry'] ?? '' }}" />
                        <input type="hidden" name="credit_card_type" id="form_credit_card_type" value="{{ $selectedCard['type'] ?? '' }}" />
                        <input type="hidden" name="credit_card_holder_name" id="form_credit_card_holder_name" value="{{ $selectedCard['holder_name'] ?? '' }}" />

                        <div class="border-t">
                            <x-checkout.inline-po-field
                                :value="$cart[0]['purchase_order_no'] ?? ''"
                                :required="true"
                            />
                        </div>

                        <div class="card-body p-6 border-t order-buttons">
                            <div class="flex flex-wrap items-center justify-center md:justify-end gap-2">
                                @if ($canSaveAsQuote ?? false)
                                <button type="submit" form="switch-to-quote-form" class="py-2 px-2 text-sm font-medium text-[#00838f] underline decoration-[#00838f] hover:text-[#005f66]">Save as a quote instead</button>
                                @endif
                                <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>
                                <button id="confirm-order" type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Place Order</button>
                            </div>
                        </div>
                    </form>
                    @if ($canSaveAsQuote ?? false)
                    {{-- Switches the stored choice to Quote and continues to the quote review.
                         Cart, shipping and payment are carried over, so nothing is re-entered. --}}
                    <form id="switch-to-quote-form" method="POST" action="{{ route('checkout.intent.switch') }}">
                        @csrf
                        <input type="hidden" name="intent" value="{{ \App\Enums\CheckoutIntent::Quote->value }}">
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <x-checkout.review-form-scripts formId="confirm-order-form" />

</x-mainpage-layout>
