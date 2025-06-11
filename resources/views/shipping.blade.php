<x-mainpage-layout>
  @section('title', 'Shipping - '.config('app.name', 'Bodypoint'))
  <x-cart-nav />
  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
           <x-checkout-header page="shipping"/>

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
                        {{ session('customer_address')['PostalCode'] ?? session('customer_details')['ShipToAddresses'][0]['PostalCode'] }}
                        @if (session('customer_address')['AddressLine5'] || !empty(session('customer_details')['ShipToAddresses'][0]['AddressLine5']))
                            ,
                        @endif
                        {{ session('customer_address')['AddressLine5'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine5'] }}  
                      </div></span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]"> +1 {{ $userDetail->primary_phone ?? $user->getUserDetails->primary_phone }}</span>
                  </li>
                </ul>
				<div class="flex items-center mb-1 sm:mb-4">
					<input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-[#00707B]-600 bg-gray-100 border-gray-300 rounded focus:ring-[#00707B]-500 focus:ring-2">
					<label for="default-checkbox" class="ms-2 text-sm font-medium text-[#00707B]">Make This My Default Address</label>
				</div>
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
                    {{-- <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->first_name ?? auth()->user()->name }} {{ $userDetail->last_name??'' }}</span> --}}
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
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $userDetail->primary_phone ?? $user->getUserDetails->primary_phone }}</span>
                  </li>
                </ul>
              </div>
            </div>
			<div>
            <a onclick="addToCart()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px] float-right" href="{{ route('payment') }}">
              Next
            </a>
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
    $(document).on('click', '.shipping-radio-class', function () {
        var key = $(this).attr("data-key");
        $('#updateShippingAddress').attr("data-key", key);
    });

    $(document).on('click', '#updateShippingAddress', function () {
        var key = $(this).attr("data-key");
        var address = $('.shipping-address-'+key).html();
        $.ajax({
            url: '{{ route('saveShippingAddress') }}',
            type: 'GET',
            data: {
                shipping_address_key: key
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Customer Address Changed Successfully');
                    $('.change-shipping-address').html(address);
                }
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    });

  </script>
@endpush

</x-mainpage-layout>
