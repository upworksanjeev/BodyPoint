<x-mainpage-layout>
  @section('title', 'Shipping & Payment - '.config('app.name', 'Bodypoint'))
  <x-cart-nav />
  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <x-checkout-header page="details" />

        @if(!empty($apiError))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <h4 class="text-red-800 font-semibold mb-2">API Error</h4>
          <p class="text-sm text-red-700">{{ $apiError }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-9">
          <div class="">
            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4  flex gap-2  sm:gap-0 flex-col sm:flex-row items-start  sm:items-center justify-start sm:justify-between border-b ">
                <h4>Shipping Information</h4>
                <button data-modal-target="default-modal" data-modal-toggle="default-modal" type="button"
                  class="py-1.5 px-4 text-sm font-normal text-[#000] focus:outline-none bg-white rounded-full border border-[#000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
                  <x-icons.map />
                  Change Address
                </button>

              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside mb-8">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Ship To:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]"> {{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : "" }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px] change-shipping-address">
                      <div>
                        {{ !empty(session('customer_address')['AddressLine2']) ? session('customer_address')['AddressLine2'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine2'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine2'] . ',': '') }}
                        {{ !empty(session('customer_address')['AddressLine1']) ? session('customer_address')['AddressLine1'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine1'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine1'] . ',': '') }}
                        {{ !empty(session('customer_address')['AddressLine3']) ? session('customer_address')['AddressLine3'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine3'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine3'] . ',': '') }}
                      </div>
                      <div>
                        {{ !empty(session('customer_address')['AddressLine4']) ? session('customer_address')['AddressLine4'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine4'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine4'] . ',' :'')  }}
                        {{ session('customer_address')['PostalCode'] ?? session('customer_details')['ShipToAddresses'][0]['PostalCode'] }},
                        {{ session('customer_address')['AddressLine5'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine5'] }}
                      </div>
                    </span>
                  </li>
                  @php
                  $phone = $userDetail->primary_phone ?? $user->getUserDetails->primary_phone;
                  @endphp

                  @if(!empty($phone))
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $phone }}</span>
                  </li>
                  @endif
                </ul>
                <div class="flex items-center mb-1 sm:mb-4">
                  <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-[#00707B]-600 bg-gray-100 border-gray-300 rounded focus:ring-[#00707B]-500 focus:ring-2">
                  <label for="default-checkbox" class="ms-2 text-sm font-medium text-[#00707B]">Make This My Default Address</label>
                </div>
              </div>
            </div>

            <div class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b">
                <h4>Payment Terms</h4>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside {{ ($shouldShowCreditCards ?? false) ? 'mb-6' : '' }}">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Payment Method:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ data_get(session('customer_details', []), 'PaymentTermDescription', 'Invoice-30') }}</span>
                  </li>
                </ul>

                @php
                  // Decided by the controller: a credit-card payment term *and* the
                  // order path. A quote captures no payment, so no card is asked for.
                  $showCards = $shouldShowCreditCards ?? false;

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
                  <div>
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

            <div class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b">
                <h4>Billing Information</h4>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Name:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : "" }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">
                      {{ !empty(session('customer_details')['billAddressLine2']) ? session('customer_details')['billAddressLine2'] . ',' : '' }}
                      <br>
                      {{ !empty(session('customer_details')['billAddressLine4']) ? session('customer_details')['billAddressLine4'] . ',' : '' }}
                      {{ !empty(session('customer_details')['billAddressLine1']) ? session('customer_details')['billAddressLine1'] . ',' : '' }}
                      @if (session('customer_details')['billAddressLine5'] || !empty(session('customer_details')['billAddressLine5']))
                      {{ !empty(session('customer_details')['billAddressPostalCode']) ? session('customer_details')['billAddressPostalCode'] . ',' : '' }}
                      @else
                      {{ !empty(session('customer_details')['billAddressPostalCode']) ? session('customer_details')['billAddressPostalCode'] : '' }}
                      @endif
                      {{ session('customer_details')['billAddressLine5'] ?? '' }}
                    </span>
                  </li>
                  @if(!empty($phone))
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $phone }}</span>
                  </li>
                  @endif
                </ul>
              </div>
            </div>

            <div>
              {{-- Continues to the review screen for the stored choice. Hidden when a
                   credit-card account has no card on file to select. --}}
              <button id="next-button" type="button" onclick="proceedToReview()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px] float-right {{ ($showCards && !$hasCards) ? 'hidden' : '' }}">
                Next
              </button>
              {{-- Escape hatch when the order path needs a card the dealer does not have on file. --}}
              @if ($canSaveAsQuote ?? false)
              <form id="save-quote-button" method="POST" action="{{ route('checkout.intent.switch') }}" class="float-right {{ ($showCards && !$hasCards) ? '' : 'hidden' }}">
                @csrf
                <input type="hidden" name="intent" value="{{ \App\Enums\CheckoutIntent::Quote->value }}">
                <button type="submit" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">
                  Save as Quote
                </button>
              </form>
              @endif
            </div>
          </div>
          <x-cart.checkout-list :cart="$cart" />
        </div>
      </div>
    </div>
  </section>
  <!-- Main modal -->
  <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
          <h3 class="text-xl font-semibold text-gray-900">
            Change Shipping Address
          </h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="default-modal">
            <x-icons.close />
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <ul class="grid w-full gap-6 md:grid-cols-2">
            @foreach(session('customer_details')['ShipToAddresses'] as $key => $address)
            <li>
              <input type="radio" id="shipping-radio-{{ $key }}" name="shipping" class="hidden peer shipping-radio-class" required data-key="{{ $key }}" />
              <label for="shipping-radio-{{ $key }}" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-gray-600 peer-checked:text-gray-600 hover:text-gray-600 hover:bg-gray-100">
                <div class="block">
                  <div class="w-full text-normal font-semibold mb-2">{{ session('customer_details')['CustomerName'] }}</div>
                  <div class="w-full text-sm font-normal leading-[17px] space-y-1 shipping-address-{{ $key }}">
                    {{ !empty($address['AddressLine1']) ? $address['AddressLine1'].',' :  '' }}<br>
                    {{ !empty($address['AddressLine2']) ? $address['AddressLine2'].',' :  '' }}<br>
                    {{ !empty($address['AddressLine3']) ? $address['AddressLine3'].',' :  ''  }}<br>
                    {{ !empty($address['State']) ? $address['State'].',' :  '' }} {{ !empty($address['PostalCode']) ? $address['PostalCode'].',' :  '' }}<br>
                    {{ !empty($address['Country']) ?? '' }}
                  </div>
                </div>
              </label>
            </li>
            @endforeach
          </ul>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
          <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[100px]">Close</button>
          <button
            data-modal-hide="default-modal"
            type="button"
            id="updateShippingAddress"
            class="py-2.5 px-5 gap-3  text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex items-center hover:bg-[#FF9119]/80 justify-center w-[100px] ml-2">
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
  @push('other-scripts')
  <script>
    $(document).on('click', '.shipping-radio-class', function() {
      var key = $(this).attr("data-key");
      $('#updateShippingAddress').attr("data-key", key);
    });

    $(document).on('click', '#updateShippingAddress', function() {
      var key = $(this).attr("data-key");
      var address = $('.shipping-address-' + key).html();
      $.ajax({
        url: '{{ route("saveShippingAddress") }}',
        type: 'GET',
        data: {
          shipping_address_key: key
        },
        success: function(response) {
          if (response.success) {
            toastr.success('Customer Address Changed Successfully');
            $('.change-shipping-address').html(address);
          }
        },
        error: function(xhr, status, error) {
          toastr.error(error);
        }
      });
    });

    // Credit card selection, shown only for credit-card accounts on the order path.
    $(document).ready(function() {
      function markSelected($radio) {
        $('.card-label').removeClass('border-[#00838f] bg-blue-50');
        $('.radio-indicator').removeClass('border-[#00838f] bg-[#00838f]');
        $('.radio-indicator .w-2').addClass('hidden');

        $radio.closest('.credit-card-option').find('.card-label').addClass('border-[#00838f] bg-blue-50');
        $radio.closest('.credit-card-option').find('.radio-indicator').addClass('border-[#00838f] bg-[#00838f]');
        $radio.closest('.credit-card-option').find('.radio-indicator .w-2').removeClass('hidden');

        $('#selected_card_data').val($radio.val());
      }

      // "Add New Card" cannot continue an order, so offer the quote instead.
      function toggleActions(value) {
        if (value === 'add_new_card') {
          $('#add_new_card_message').removeClass('hidden');
          $('#next-button').addClass('hidden');
          $('#save-quote-button').removeClass('hidden');
        } else {
          $('#add_new_card_message').addClass('hidden');
          $('#next-button').removeClass('hidden');
          $('#save-quote-button').addClass('hidden');
        }
      }

      var checkedRadio = $('.credit-card-radio:checked');
      if (checkedRadio.length > 0) {
        markSelected(checkedRadio);
        toggleActions(checkedRadio.val());
      }

      $('.credit-card-radio').on('change', function() {
        if ($(this).is(':checked')) {
          markSelected($(this));
          toggleActions($(this).val());
        }
      });
    });

    function proceedToReview() {
      const selectedCard = $('input[name="selected_credit_card"]:checked');

      if (selectedCard.length === 0) {
        if ($('.credit-card-radio').length > 0) {
          toastr.error('Please select a credit card');
          return;
        }
        // No card selector on this account, so nothing to validate.
      } else {
        const cardData = selectedCard.val();
        localStorage.setItem('selected_credit_card', cardData);
        sessionStorage.setItem('selected_credit_card', cardData);
      }

      // Let the server route to the review screen for the stored order-or-quote
      // choice, so a cached page can never send this down the wrong path.
      window.location.href = '{{ route("checkout.continue") }}';
    }
  </script>
  @endpush

</x-mainpage-layout>
