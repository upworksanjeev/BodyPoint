@php
  $previousSelectedCard = session('selected_credit_card');
@endphp
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

            <form method="POST" action="{{ route('payment.select-card') }}" id="select-card-form">
              @csrf
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
                    $canShowCreditCards = $shouldShowCreditCards ?? false;
                  @endphp

                  @if($canShowCreditCards)
                    <div class="mb-4">
                      <h5 class="text-sm font-semibold text-[#000] mb-3">Saved Cards:</h5>
                      <div class="space-y-3">
                        @php
                          // Handle both array of cards and single card object
                          $cards = is_array($creditCardDetails) && isset($creditCardDetails[0]) ? $creditCardDetails : [];
                          if (empty($cards) && !empty($creditCardDetails)) {
                            // If it's a single card object, wrap it in an array
                            $cards = [$creditCardDetails];
                          }
                        @endphp

                        @if(!empty($cards))
                          @foreach($cards as $index => $card)
                            @php
                              $encodedCard = json_encode($card);
                              $isSelected = $previousSelectedCard ? $previousSelectedCard === $encodedCard : $index === 0;
                            @endphp
                            <div class="credit-card-option">
                              <input type="radio" id="card_{{ $index }}" name="selected_credit_card_option" value='{{ $encodedCard }}' class="hidden credit-card-radio" data-card-index="{{ $index }}" {{ $isSelected ? 'checked' : '' }} />
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
                        @else
                          <p class="text-sm text-gray-500">No saved credit cards found.</p>
                        @endif
                      </div>
                    </div>
                  @endif

                  <input type="hidden" name="selected_credit_card" id="selected_credit_card" value="">
                  <input type="hidden" name="credit_card_last_four" id="credit_card_last_four" value="">
                  <input type="hidden" name="credit_card_expiry" id="credit_card_expiry" value="">
                  <input type="hidden" name="credit_card_type" id="credit_card_type" value="">
                  <input type="hidden" name="credit_card_holder_name" id="credit_card_holder_name" value="">
                </div>
              </div>

			  <div>
              <button type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px] float-right">
                Next
              </button>
            </div>
            </form>
          </div>
         <x-cart.checkout-list :cart="$cart" />
        </div>
      </div>
    </div>
  </section>

  @push('other-scripts')
  <script>
    function populateHiddenCardFields(cardValue) {
      if (!cardValue) {
        $('#selected_credit_card').val('');
        $('#credit_card_last_four').val('');
        $('#credit_card_expiry').val('');
        $('#credit_card_type').val('');
        $('#credit_card_holder_name').val('');
        return;
      }

      $('#selected_credit_card').val(cardValue);

      try {
        const cardData = JSON.parse(cardValue);
        $('#credit_card_last_four').val(cardData.CreditCardLastFourDigit || cardData.CreditCardLast4Digit || cardData.LastFourDigit || cardData.Last4Digit || '');
        $('#credit_card_expiry').val(cardData.ExpiredDate || (cardData.ExpiryMonth && cardData.ExpiryYear ? `${String(cardData.ExpiryMonth).padStart(2, '0')}/${cardData.ExpiryYear}` : ''));
        $('#credit_card_type').val(cardData.CardType || '');
        $('#credit_card_holder_name').val(cardData.CardHolderName || '');
      } catch (error) {
        console.error('Unable to parse selected credit card data', error);
      }
    }

    $(document).ready(function() {
      function highlightSelection(radio) {
        $('.card-label').removeClass('border-[#00838f] bg-blue-50');
        $('.radio-indicator').removeClass('border-[#00838f] bg-[#00838f]');
        $('.radio-indicator .w-2').addClass('hidden');

        if (radio && radio.length) {
          radio.closest('.credit-card-option').find('.card-label').addClass('border-[#00838f] bg-blue-50');
          radio.closest('.credit-card-option').find('.radio-indicator').addClass('border-[#00838f] bg-[#00838f]');
          radio.closest('.credit-card-option').find('.radio-indicator .w-2').removeClass('hidden');
        }
      }

      const initiallyChecked = $('.credit-card-radio:checked');
      if (initiallyChecked.length) {
        populateHiddenCardFields(initiallyChecked.val());
        highlightSelection(initiallyChecked);
      }

      $('.credit-card-radio').on('change', function() {
        if ($(this).is(':checked')) {
          populateHiddenCardFields($(this).val());
          highlightSelection($(this));
        }
      });

      $('#select-card-form').on('submit', function(event) {
        const selectedCard = $('input[name="selected_credit_card_option"]:checked');
        if (selectedCard.length === 0 && $('.credit-card-radio').length > 0) {
          event.preventDefault();
          toastr.error('Please select a credit card');
          return false;
        }

        if (selectedCard.length) {
          populateHiddenCardFields(selectedCard.val());
        } else {
          populateHiddenCardFields('');
        }
        return true;
      });
    });
  </script>
  @endpush

</x-mainpage-layout>

