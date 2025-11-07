<x-mainpage-layout>
    <x-cart-nav />
    <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
        <div class="container mx-auto">
            <div class="max-w-screen-xl mx-auto">
                <x-checkout-header page="checkout" />
                <div class="pb-6">
                    <p class="text-[13px] font-normal leading-[19px] text-center">Your order summary is provided below. Please review carefully and click confirm order to process your order. Click cancel to return to your shopping cart.</p>
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
                                <li class="flex items-center gap-5">
                                    <span class="text-sm text-[#000] font-normal leading-[17px]">Your Purchase Order No.:</span>
                                    <span class="py-[2px] px-5 text-sm text-white focus:outline-none bg-[#31BA32] rounded-full border border-[#31BA32] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center font-bold">Quote</span>
                                </li>
                            </ul>
                        </div>
                        <x-shipping-info :userDetail="$user_detail" :cart="$cart" :user="$user" />
                        <x-cart.final-checkout-list :cart="$cart" />
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
                        <input type="hidden" name="selected_credit_card" id="quote_credit_card_data" value="" />
                        <input type="hidden" name="price_option" id="quote_price_option" value="all_price" />
                        <div class="card-body p-6 border-t quote-buttons">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>
                                <button id="generate-quote" type="button" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Generate Quote</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

   <x-modals.po-number
    save="save-po-number-quote"
    cross="close-cross-po-modal-quote"
    name="customer-po-number-quote"
    id="po-number-modal-quote"
    class="close-po-number-modal-quote"
    form="generate-quote-form"
    action="{{ route('generateQuote') }}"/>

    @push('other-scripts')
    <script>
        function print_window() {
            window.print();
        }

        // Function to retrieve and add credit card data to quote form
        function addCreditCardToQuoteForm() {
            const selectedCard = localStorage.getItem('selected_credit_card') || sessionStorage.getItem('selected_credit_card');
            const form = $('#generate-quote-form');
            if (selectedCard) {
                try {
                    const cardData = JSON.parse(selectedCard);
                    
                    // ALWAYS set the selected_credit_card field - this is critical for backend processing
                    form.find('#quote_credit_card_data').val(selectedCard);
                    
                    // Add individual fields for easier access
                    if (cardData.CreditCardLastFourDigit) {
                        if (!form.find('input[name="credit_card_last_four"]').length) {
                            form.append('<input type="hidden" name="credit_card_last_four" value="" />');
                        }
                        form.find('input[name="credit_card_last_four"]').val(cardData.CreditCardLastFourDigit);
                    }
                    
                    if (cardData.ExpiredDate) {
                        if (!form.find('input[name="credit_card_expiry"]').length) {
                            form.append('<input type="hidden" name="credit_card_expiry" value="" />');
                        }
                        form.find('input[name="credit_card_expiry"]').val(cardData.ExpiredDate);
                    }
                    
                    if (cardData.CardType) {
                        if (!form.find('input[name="credit_card_type"]').length) {
                            form.append('<input type="hidden" name="credit_card_type" value="" />');
                        }
                        form.find('input[name="credit_card_type"]').val(cardData.CardType);
                    }
                    
                    if (cardData.CardHolderName) {
                        if (!form.find('input[name="credit_card_holder_name"]').length) {
                            form.append('<input type="hidden" name="credit_card_holder_name" value="" />');
                        }
                        form.find('input[name="credit_card_holder_name"]').val(cardData.CardHolderName);
                    }
                    
                    // Debug: Log credit card data being added
                    console.log('Credit Card Data added to quote form:', {
                        selected_credit_card: selectedCard,
                        cardData: cardData
                    });
                } catch (e) {
                    console.error('Error parsing credit card data:', e);
                }
            } else {
                console.warn('No credit card data found in localStorage or sessionStorage for quote');
            }
            
            // Update price option in form
            const selectedPriceOption = $('.quote-price-option:checked').val();
            if (selectedPriceOption) {
                form.find('#quote_price_option').val(selectedPriceOption);
            }
        }

        $(document).on('click', '#generate-quote', function(event) {
            event.preventDefault();
            const po_number = $('#customer-po-number-quote').val();
            addCreditCardToQuoteForm();
            $('#generate-quote-form').submit();
            // if (po_number !== "" && po_number !== null) {
            //     $('#generate-quote-form').submit();
            // }else{
            //     $('#po-number-modal-quote').show();
            //     $('#po-number-modal-quote').css({
            //         'display': 'flex',
            //         'background-color': 'rgb(0 0 0 / 56%)'
            //     });
            // }
        });

        $(document).on('click','#save-po-number-quote',function(){
            const po_number = $('#customer-po-number-quote').val();
            if (po_number == "" || po_number == null) {
                toastr.error('Customer PO Number is Required');
            }else {
                $('.po-number-div').remove();
                $('.quote-buttons').before('<div class="po-number-div flex justify-end gap-3 flex-wrap px-6 pb-6">' +
                    '<div class="min-w-[250px]">' +
                        '<span class="text-sm text-[#000] font-bold leading-[17px]">Your PO Number Is:</span>' +
                    '</div>' +
                    '<div class="min-w-[100px] text-right">' +
                        '<span class="font-bold mr-2">' + po_number + '</span> ' +
                        '<button data-modal-target="po-number-modal-quote" data-modal-toggle="po-number-modal-quote" class="edit-customer-po-number-quote" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>' +
                    '</div>' +
                '</div>');
                $('#po-number-modal-quote').hide();
                addCreditCardToQuoteForm();
            }
        });


        $(document).on('click', '.edit-customer-po-number-quote', function() {
            $('#po-number-modal-quote').show();
            $('#po-number-modal-quote').css({
                'display': 'flex',
                'background-color': 'rgb(0 0 0 / 56%)'
            });
        });

        $(document).on('click', '.close-po-number-modal-quote, .close-cross-po-modal-quote', function() {
            $('#po-number-modal-quote').hide();
        });

    </script>
    @endpush

</x-mainpage-layout>
