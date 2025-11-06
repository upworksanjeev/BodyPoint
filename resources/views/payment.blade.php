<x-mainpage-layout>
  @section('title', 'Payment - '.config('app.name', 'Bodypoint'))

  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
       <x-checkout-header page="payment"/>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-9">
          <div class="">
            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b ">
                <h4>Choose Payment</h4>

              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Payment Method:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ session('customer_details')['PaymentTermDescription'] ?? 'Invoice-30' }}</span>
                  </li>

                </ul>

                
                @if(isset($creditCardDetails) && !empty($creditCardDetails))
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
                      @else
                        <p class="text-sm text-gray-500">No saved credit cards found.</p>
                      @endif
                    </div>
                  </div>
                @else
                  <div class="mb-4">
                    <p class="text-sm text-gray-500">No saved credit cards available.</p>
                  </div>
                @endif

                <input type="hidden" id="selected_card_data" name="selected_card_data" value="" />

              </div>
            </div>

			<div>
            <a onclick="proceedToCheckout()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px] float-right" href="{{ route('checkout') }}">
              Next
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
        }
      });
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

