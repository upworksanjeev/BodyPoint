<x-mainpage-layout>
    <x-cart-nav />
    <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
        <div class="container mx-auto">
            <div class="max-w-screen-xl mx-auto">
                <x-checkout-header page="review" />
                <div class="pb-6">
                    <p class="text-[13px] font-normal leading-[19px] text-center">Your quote summary is provided below. Please review carefully and click generate quote to save your quote. Click cancel to return to your shopping cart.</p>
                </div>
                <div class="card w-full max-w-[920px] m-auto bg-white border border-gray-200 rounded-2xl shadow mb-4">
                    <div id="quote_print_div">
                        <div class="card-header px-6 py-2 bg-[#00838f] rounded-t-xl">
                            <h4 class="text-[#fff]">Quote Details:</h4>
                        </div>
                        <div class="card-body p-6">
                            <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                                <li class="flex items-start gap-5">
                                    <span class="text-sm text-[#000] font-normal leading-[17px]">Quote No.:</span>
                                    <span class="text-sm text-[#000] font-normal leading-[17px]"></span>
                                </li>
                            </ul>
                        </div>
                        <x-shipping-info :userDetail="$user_detail" :cart="$cart" :user="$user" :editRoute="route('shipping')" />
                        <x-cart.final-checkout-list :cart="$cart" :editable="true" :hidePoSummary="true" />
                    </div>
                    <div class="card-body p-6 border-t">
                        <h3 class="mb-4 font-semibold text-gray-900">Select a PDF Quote Option to Save</h3>
                        <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                                <div class="flex items-center ps-3">
                                    <input id="all_price" type="radio" value="all_price" name="price_option" class="quote-price-option w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" checked>
                                    <label for="all_price" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">All Price</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                                <div class="flex items-center ps-3">
                                    <input id="msrp_primary" type="radio" value="msrp_primary" name="price_option" class="quote-price-option w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                    <label for="msrp_primary" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">MSRP and Primary</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
                                <div class="flex items-center ps-3">
                                    <input id="msrp_only" type="radio" value="msrp_only" name="price_option" class="quote-price-option w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                    <label for="msrp_only" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">MSRP Only</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <form id="generate-quote-form" action="{{ route('generateQuote') }}" method="post">
                        <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                        <input type="hidden" name="selected_credit_card" id="quote_credit_card_data" value="{{ $selectedCard['json'] ?? '' }}" />
                        <input type="hidden" name="credit_card_last_four" id="quote_credit_card_last_four" value="{{ $selectedCard['last_four'] ?? '' }}" />
                        <input type="hidden" name="credit_card_expiry" id="quote_credit_card_expiry" value="{{ $selectedCard['expiry'] ?? '' }}" />
                        <input type="hidden" name="credit_card_type" id="quote_credit_card_type" value="{{ $selectedCard['type'] ?? '' }}" />
                        <input type="hidden" name="credit_card_holder_name" id="quote_credit_card_holder_name" value="{{ $selectedCard['holder_name'] ?? '' }}" />
                        <input type="hidden" name="price_option" id="quote_price_option" value="all_price" />

                        <div class="border-t">
                            <x-checkout.inline-po-field
                                id="customer-po-number-quote"
                                name="customer_po_number"
                                :value="$cart[0]['purchase_order_no'] ?? ''"
                                :required="false"
                            />
                        </div>

                        <div class="card-body p-6 border-t quote-buttons">
                            <div class="flex flex-wrap items-center justify-center md:justify-end gap-2">
                                @if ($canPlaceOrder ?? false)
                                {{-- Submits the form below, which sits outside the quote form so the
                                     two are never nested. --}}
                                <button type="submit" form="switch-to-order-form" class="py-2 px-2 text-sm font-medium text-[#00838f] underline decoration-[#00838f] hover:text-[#005f66]">Place order instead</button>
                                @endif
                                <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>
                                <button id="generate-quote" type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Generate Quote</button>
                            </div>
                        </div>
                    </form>
                    @if ($canPlaceOrder ?? false)
                    {{-- Switches the stored choice to Order and continues to the order review.
                         The cart and shipping selections are carried over; a credit-card account
                         is sent back a step to pick a card first. --}}
                    <form id="switch-to-order-form" method="POST" action="{{ route('checkout.intent.switch') }}">
                        @csrf
                        <input type="hidden" name="intent" value="{{ \App\Enums\CheckoutIntent::Order->value }}">
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @push('other-scripts')
    <script>
        function syncQuotePriceOption() {
            const selectedPriceOption = $('.quote-price-option:checked').val();
            if (selectedPriceOption) {
                $('#quote_price_option').val(selectedPriceOption);
            }
        }

        syncQuotePriceOption();

        $(document).on('change', '.quote-price-option', function() {
            syncQuotePriceOption();
        });

        $('#generate-quote-form').on('submit', function() {
            syncQuotePriceOption();
        });
    </script>
    @endpush

    <x-checkout.review-form-scripts formId="generate-quote-form" poFieldId="customer-po-number-quote" :requirePo="false" />

</x-mainpage-layout>
