<x-mainpage-layout>
  @section('title', 'Payment - '.config('app.name', 'Bodypoint'))

  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
       <x-checkout-header page="payment"/>

        @if(isset($apiError))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <h4 class="text-red-800 font-semibold mb-2">API Error</h4>
          <p class="text-sm text-red-700">{{ $apiError }}</p>
        </div>
        @endif

        @if(isset($apiCustomerDetails) && !empty($apiCustomerDetails))
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
          <h4 class="text-blue-800 font-semibold mb-3">Customer Details from API (http://209.119.205.198:25374/api/GetCustomerDetails/105019)</h4>
          
          @if(isset($apiCustomerDetails['Customer']))
            @php
              $apiCustomer = $apiCustomerDetails['Customer'];
            @endphp
            <div class="mb-4">
              <h5 class="text-sm font-semibold text-[#000] mb-2">Customer Information:</h5>
              <ul class="text-sm text-[#000] space-y-1">
                @if(isset($apiCustomer['CustomerName']))
                <li><span class="font-medium">Name:</span> {{ $apiCustomer['CustomerName'] }}</li>
                @endif
                @if(isset($apiCustomer['CustomerAccountNumber']))
                <li><span class="font-medium">Account Number:</span> {{ $apiCustomer['CustomerAccountNumber'] }}</li>
                @endif
                @if(isset($apiCustomer['PaymentTermDescription']))
                <li><span class="font-medium">Payment Term:</span> {{ $apiCustomer['PaymentTermDescription'] }}</li>
                @endif
                @if(isset($apiCustomer['CustomerDiscountPercentage']))
                <li><span class="font-medium">Discount Percentage:</span> {{ $apiCustomer['CustomerDiscountPercentage'] }}%</li>
                @endif
              </ul>
            </div>

            @if(isset($apiCustomer['ShipToAddresses']) && is_array($apiCustomer['ShipToAddresses']) && !empty($apiCustomer['ShipToAddresses']))
            <div class="mb-4">
              <h5 class="text-sm font-semibold text-[#000] mb-2">Shipping Addresses:</h5>
              @foreach($apiCustomer['ShipToAddresses'] as $index => $address)
              <div class="mb-3 p-3 bg-white rounded border">
                <p class="text-xs font-medium text-gray-600 mb-1">Address #{{ $index + 1 }}</p>
                <ul class="text-sm text-[#000] space-y-1">
                  @if(isset($address['AddressLine1']))<li>{{ $address['AddressLine1'] }}</li>@endif
                  @if(isset($address['AddressLine2']))<li>{{ $address['AddressLine2'] }}</li>@endif
                  @if(isset($address['AddressLine3']))<li>{{ $address['AddressLine3'] }}</li>@endif
                  @if(isset($address['AddressLine4']))<li>{{ $address['AddressLine4'] }}</li>@endif
                  @if(isset($address['PostalCode']) || isset($address['AddressLine5']))
                  <li>
                    @if(isset($address['PostalCode'])){{ $address['PostalCode'] }}@endif
                    @if(isset($address['PostalCode']) && isset($address['AddressLine5'])), @endif
                    @if(isset($address['AddressLine5'])){{ $address['AddressLine5'] }}@endif
                  </li>
                  @endif
                </ul>
              </div>
              @endforeach
            </div>
            @endif
          @endif

          <div class="mt-4">
            <details class="text-sm">
              <summary class="cursor-pointer text-blue-700 font-medium hover:text-blue-900">View Raw JSON Response</summary>
              <pre class="mt-2 p-3 bg-white border rounded overflow-auto text-xs" style="max-height: 400px;">{{ json_encode($apiCustomerDetails, JSON_PRETTY_PRINT) }}</pre>
            </details>
          </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-9">
          <div class="">
            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b ">
                <h4>Customer Information</h4>

              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside mb-8">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Name:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ data_get(session('customer_details', []), 'CustomerName', '') }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">
                      @php
                        $customerDetailsPayment = session('customer_details', []);
                        $customerAddressPayment = session('customer_address', []);
                        $shipToAddressesPayment = data_get($customerDetailsPayment, 'ShipToAddresses', []);
                        $defaultAddressPayment = !empty($shipToAddressesPayment) && isset($shipToAddressesPayment[0]) ? $shipToAddressesPayment[0] : [];
                      @endphp
                      <div>
                        {{ !empty($customerAddressPayment['AddressLine2']) ? $customerAddressPayment['AddressLine2'] . ',' : (data_get($defaultAddressPayment, 'AddressLine2') ? data_get($defaultAddressPayment, 'AddressLine2') . ',': '') }}
                        {{ !empty($customerAddressPayment['AddressLine1']) ? $customerAddressPayment['AddressLine1'] . ',' : (data_get($defaultAddressPayment, 'AddressLine1') ? data_get($defaultAddressPayment, 'AddressLine1') . ',': '') }}
                        {{ !empty($customerAddressPayment['AddressLine3']) ? $customerAddressPayment['AddressLine3'] . ',' : (data_get($defaultAddressPayment, 'AddressLine3') ? data_get($defaultAddressPayment, 'AddressLine3') . ',': '') }}
                      </div>
                      <div>
                        {{ !empty($customerAddressPayment['AddressLine4']) ? $customerAddressPayment['AddressLine4'] . ',' : (data_get($defaultAddressPayment, 'AddressLine4') ? data_get($defaultAddressPayment, 'AddressLine4') . ',' :'')  }}
                        {{ $customerAddressPayment['PostalCode'] ?? data_get($defaultAddressPayment, 'PostalCode') }},
                        {{ $customerAddressPayment['AddressLine5'] ?? data_get($defaultAddressPayment, 'AddressLine5') }}
                      </div>
                    </span>
                  </li>
                </ul>
              </div>
            </div>

            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b ">
                <h4>Choose Payment</h4>

              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside mb-6">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Payment Method:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ data_get(session('customer_details', []), 'PaymentTermDescription', 'Invoice-30') }}</span>
                  </li>
                </ul>

                @php
                  // Check if we should show credit cards based on PaymentTermCode
                  $shouldShowCreditCards = isset($shouldShowCreditCards) && $shouldShowCreditCards === true;
                  $paymentTermIsCC = isset($paymentTermCode) && $paymentTermCode === 'CC';
                  $showCards = $shouldShowCreditCards || $paymentTermIsCC;
                  
                  // Handle both array of cards and single card object
                  $cards = [];
                  if ($showCards && isset($creditCardDetails) && !empty($creditCardDetails)) {
                    $cards = is_array($creditCardDetails) && isset($creditCardDetails[0]) ? $creditCardDetails : []; 
                    if (empty($cards) && !empty($creditCardDetails)) {
                      // If it's a single card object, wrap it in an array
                      $cards = [$creditCardDetails];
                    }
                  }
                  $hasCards = !empty($cards);
                @endphp

                @if($showCards)
                  <div class="mb-4">
                    @if($hasCards)
                      <h5 class="text-sm font-semibold text-[#000] mb-3">Saved Cards:</h5>
                    @endif
                    <div class="space-y-3">
                      @if($hasCards)
                        @foreach($cards as $index => $card)
                          <div class="credit-card-option">
                            <input type="radio" id="card_{{ $index }}" name="selected_credit_card" value="{{ json_encode($card) }}" class="hidden credit-card-radio" data-card-index="{{ $index }}" {{ $index === 0 ? 'checked' : '' }} />
                            <label for="card_{{ $index }}" class="flex items-center gap-4 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 card-label">
                              <div class="w-4 h-4 border-2 border-gray-300 rounded-full radio-indicator flex items-center justify-center flex-shrink-0">
                                <div class="w-2 h-2 bg-white rounded-full hidden"></div>
                              </div>
                              <div class="flex-1 flex items-center gap-4 text-sm text-gray-600">
                                @if(isset($card['CardType']))
                                  <span><span class="font-medium">Type:</span> {{ $card['CardType'] }}</span>
                                @endif
                                @if(isset($card['CreditCardLastFourDigit']))
                                  <span><span class="font-medium">Number:</span> ****{{ $card['CreditCardLastFourDigit'] }}</span>
                                @elseif(isset($card['CardNumber']))
                                  <span><span class="font-medium">Number:</span> ****{{ substr($card['CardNumber'], -4) }}</span>
                                @elseif(isset($card['Last4Digits']))
                                  <span><span class="font-medium">Number:</span> ****{{ $card['Last4Digits'] }}</span>
                                @endif
                                @if(isset($card['ExpiredDate']))
                                  <span><span class="font-medium">Expiry:</span> {{ $card['ExpiredDate'] }}</span>
                                @elseif(isset($card['ExpiryMonth']) && isset($card['ExpiryYear']))
                                  <span><span class="font-medium">Expiry:</span> {{ str_pad($card['ExpiryMonth'], 2, '0', STR_PAD_LEFT) }}/{{ $card['ExpiryYear'] }}</span>
                                @endif
                                @if(isset($card['CardHolderName']))
                                  <span><span class="font-medium">Name:</span> {{ $card['CardHolderName'] }}</span>
                                @endif
                              </div>
                            </label>
                          </div>
                        @endforeach
                      @endif

                      {{-- Add New Card Radio Button --}}
                      <div class="credit-card-option">
                        <input type="radio" id="add_new_card" name="selected_credit_card" value="add_new_card" class="hidden credit-card-radio" data-card-index="add_new" {{ !$hasCards ? 'checked' : '' }} />
                        <label for="add_new_card" class="flex items-center gap-4 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 card-label">
                          <div class="w-4 h-4 border-2 border-gray-300 rounded-full radio-indicator flex items-center justify-center flex-shrink-0">
                            <div class="w-2 h-2 bg-white rounded-full hidden"></div>
                          </div>
                          <div class="flex-1 flex items-center gap-4 text-sm text-gray-600">
                            <span class="font-medium">Add New Card</span>
                          </div>
                        </label>
                      </div>

                      {{-- Support message shown when Add New Card is selected --}}
                      <div id="add_new_card_message" class="mt-3 p-4 bg-gray-50 border border-gray-200 rounded-lg {{ !$hasCards ? '' : 'hidden' }}">
                        <p class="text-sm text-gray-700">
                          You do not have any cards on file. To add or change your credit card on file and continue with your order, please call support at <a href="tel:8005475716" class="text-[#00838f] hover:underline font-medium">800.547.5716</a>.
                        </p>
                      </div>
                    </div>
                  </div>
                @endif

                <input type="hidden" id="selected_card_data" name="selected_card_data" value="" />
              </div>
            </div>

      <div>
            {{-- Next Button - shown when PaymentTermCode is NOT CC, or when a saved card is selected (if CC) --}}
            <button id="next-button" type="button" onclick="proceedToCheckout()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px] float-right {{ ($showCards && !$hasCards) ? 'hidden' : '' }}">
              Next
            </button>
            {{-- Save a Quote Button - shown only when PaymentTermCode is CC and Add New Card is selected --}}
            <a id="save-quote-button" href="{{ route('quote') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px] float-right {{ ($showCards && !$hasCards) ? '' : 'hidden' }}">
              Save a Quote
            </a>
          </div>
          </div>
         <x-cart.checkout-list :cart="$cart" />
        </div>
      </div>
    </div>
  </section>

  @push('other-scripts')
  <script>
    // Handle credit card radio button selection
    $(document).ready(function() {
      // Update visual indicator for checked card on page load
      $('.credit-card-radio:checked').each(function() {
        $(this).closest('.credit-card-option').find('.card-label').addClass('border-[#00838f] bg-blue-50');
        $(this).closest('.credit-card-option').find('.radio-indicator').addClass('border-[#00838f] bg-[#00838f]');
        $(this).closest('.credit-card-option').find('.radio-indicator .w-2').removeClass('hidden');
        // Store selected card data
        $('#selected_card_data').val($(this).val());
      });

      $('.credit-card-radio').on('change', function() {
        // Update visual indicator
        $('.card-label').removeClass('border-[#00838f] bg-blue-50');
        $('.radio-indicator').removeClass('border-[#00838f] bg-[#00838f]');
        $('.radio-indicator .w-2').addClass('hidden');
        
        if ($(this).is(':checked')) {
          $(this).closest('.credit-card-option').find('.card-label').addClass('border-[#00838f] bg-blue-50');
          $(this).closest('.credit-card-option').find('.radio-indicator').addClass('border-[#00838f] bg-[#00838f]');
          $(this).closest('.credit-card-option').find('.radio-indicator .w-2').removeClass('hidden');
          
          // Store selected card data
          $('#selected_card_data').val($(this).val());

          // Toggle message and buttons based on selection
          if ($(this).val() === 'add_new_card') {
            // Show support message, hide Next button, show Save a Quote button
            $('#add_new_card_message').removeClass('hidden');
            $('#next-button').addClass('hidden');
            $('#save-quote-button').removeClass('hidden');
          } else {
            // Hide support message, show Next button, hide Save a Quote button
            $('#add_new_card_message').addClass('hidden');
            $('#next-button').removeClass('hidden');
            $('#save-quote-button').addClass('hidden');
          }
        }
      });

      // Initialize message and button visibility on page load
      // Only toggle buttons if credit card section is visible (PaymentTermCode is 'CC')
      const checkedRadio = $('.credit-card-radio:checked');
      if (checkedRadio.length > 0) {
        if (checkedRadio.val() === 'add_new_card') {
          $('#add_new_card_message').removeClass('hidden');
          $('#next-button').addClass('hidden');
          $('#save-quote-button').removeClass('hidden');
        } else {
          $('#add_new_card_message').addClass('hidden');
          $('#next-button').removeClass('hidden');
          $('#save-quote-button').addClass('hidden');
        }
      }
      // If no credit card radios exist (PaymentTermCode is NOT 'CC'), Next button stays visible by default
    });

    function proceedToCheckout() {
      const selectedCard = $('input[name="selected_credit_card"]:checked');
      
      if (selectedCard.length === 0) {
        // Check if credit cards are available
        if ($('.credit-card-radio').length > 0) {
          toastr.error('Please select a credit card');
          return;
        }
        // If no credit cards available, proceed without card
      } else {
        // Store selected card in session/localStorage for checkout
        const cardData = selectedCard.val();
        localStorage.setItem('selected_credit_card', cardData);
        sessionStorage.setItem('selected_credit_card', cardData);
      }
      
      // Redirect to checkout
      window.location.href = '{{ route("checkout") }}';
    }
  </script>
  @endpush

</x-mainpage-layout>
