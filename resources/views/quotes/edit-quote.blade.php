@php
  $customer = getCustomer();
@endphp
<x-mainpage-layout>
  @section('title', 'Edit Quote - ' . config('app.name', 'Bodypoint'))
  <x-cart-nav />

  <!-- Quote Edit Instructions -->
  <section class="bg-[#fdffff] py-7 lg:py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="pb-6">
          <p class="text-[20px] font-normal leading-[24px] mb-4">
            Please review and update your quote line items as necessary. You can add new items, update quantities, or remove items.
          </p>
          <ol class="text-sm font-normal text-[#000] leading-[29px]">
            <li>1. Search for a product using the Stock Code.</li>
            <li>2. Select the product, adjust quantity and other details.</li>
            <li>3. Click "Update Quote" to refresh your quote.</li>
          </ol>
        </div>

        <!-- Search and Add/Edit Item Section -->
        <div class="flex items-baseline lg:items-center lg:flex-row flex-col gap-4 justify-start mb-6">
          <div class="lg:w-[35%] w-full">
            <div class="relative">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <x-icons.search />
              </div>
              <input type="search" id="myInput" onkeyup="myFunction()" 
                class="block w-full p-3 ps-10 text-sm text-[#000] border border-[#000] rounded-full bg-white focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#000]" 
                placeholder="Enter Stock Code" required />
              <button type="button" class="text-white absolute end-2.5 top-0 bottom-0 right-0 bg-[#2F2F2F] hover:bg-[#000] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-e-full text-sm px-5 py-3" onclick="clearStock()">Clear</button>
              <div id="stock_search_div" class="hidden">
                <div class="h-full min-h-[250px] max-h-[360px] overflow-y-auto absolute top-45 w-full left-0 z-10">
                  <table id="myTable" class="rounded-xl shadow-lg bg-white">
                    <thead class="header top-0">
                      <tr>
                        <th scope="col" style="width: 30%;" class="text-white">Stock Code</th>
                        <th scope="col" style="width: 70%;" class="text-white">Name</th>
                      </tr>
                    </thead>
                    <tbody id="stock_search_table"></tbody>
                  </table>
                </div>
              </div>
            </div>
            <input id="selected_product_id" type="hidden">
            <input id="variation_id" type="hidden">
          </div>

          <div class="flex items-center gap-3">
            <label class="text-md font-normal text-[#000] leading-[18px]">Qty</label>
            <input type="number" id="qty" class="block w-full py-2 px-3 text-sm text-[#000] border border-[#000] rounded-full bg-white min-w-[72px] max-w-[72px] text-center" placeholder="01" />
          </div>

          <div>
           
              <button type="button" onclick="addToQuote()" 
                class="py-2.5 px-5 text-sm font-medium text-white bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">
                {{-- <div class="w-[20px] h-[20px]">
                  <x-icons.basket />
                </div> --}}
                Add To Quote
              </button>
           
          </div>
        </div>

        <!-- Quote Items List -->
        <div class="relative overflow-x-auto shadow-md rounded-2xl">
          <x-quote-product-list page="quote" :quote="$quote" />
        </div>

        <!-- Button to navigate to full quote edit page (if needed) -->
        <div class="pt-4 md:pt-6 pb-2 text-right">
          <a href="{{ route('quote.edit', $quote->id) }}"
             class="text-base text-[#00707B] font-normal flex items-center justify-end gap-2">
             Full Quote Edit <x-icons.next-arrow />
          </a>
        </div>
      </div>
    </div>

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
                                            {{ $address['AddressLine1'] ?? '' }}<br>
                                            {{ $address['AddressLine2'] ?? '' }}<br>
                                            {{ $address['AddressLine3'] ?? '' }}<br>
                                            {{ $address['State'] }} {{ $address['PostalCode'] ?? '' }}<br>
                                            {{ $address['Country'] ?? '' }}
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
  </section>

  @push('other-scripts')
    <script>
      function myFunction() {
        $("#stock_search_div").addClass("hidden").removeClass("block");
        $.ajax({
          url: "{{ route('search-product') }}",
          type: 'POST',
          data: {
            "_token": "{{ csrf_token() }}",
            keys: $('#myInput').val(),
          },
          success: function(response) {
            $('#stock_search_table').html(response);
            if(response.trim() !== ''){
              $("#stock_search_div").addClass("block").removeClass("hidden");
            }
          }
        });
      }

      function clearStock() {
        $("#stock_search_div").addClass("hidden").removeClass("block");
        $('#myInput').val('');
        $('#selected_product_id').val('');
        $('#qty').val('');
        $('#variation_id').val('');
      }

      function chooseProduct(sku, product_id, variation_id) {
        $("#stock_search_div").addClass("hidden").removeClass("block");
        $('#myInput').val(sku);
        $('#selected_product_id').val(product_id);
        $('#variation_id').val(variation_id);
        $('#qty').val(1);
      }

      // Function to update quote item (similar to addToCart but for quote update)
      function addToQuote() {
        $('#error_alert').remove();
        if($('#selected_product_id').val() === ''){
          $('#myInput').addClass('focus:ring-red-500 focus:border-red-500').focus();
          return;
        }
        if($('#qty').val() === ''){
          $('#qty').addClass('focus:ring-red-300').focus();
          return;
        }
        $('#myInput').removeClass('focus:ring-red-500 focus:border-red-500').addClass('focus:ring-blue-500 focus:border-blue-500');
        $('#qty').removeClass('focus:ring-red-300').addClass('focus:ring-blue-300');
        $.ajax({
          url: "{{route('add-to-quote', $quote->id)}}", // Set to your update quote item route route('update-quote-item', $quote->id)
          type: 'POST',
          data: {
            "_token": "{{ csrf_token() }}",
            product_id: $('#selected_product_id').val(),
            sku: $('#myInput').val(),
            variation_id: $('#variation_id').val(),
            qty: $('#qty').val(),
          },
          success: function(response) {
            if(response.success === false){
              toastr.error(response.message);
              return;
            }
            // Update quote list on page
            $('#tbody_data').html(response);
            // Optionally update header quote count
            // $.ajax({
            //   url: "", // route('get-quote-count') 
            //   type: 'GET',
            //   success: function(response) {
            //     $('#quote_count_div').html(response);
            //   }
            // });
            clearStock();
          }
        });
      }

      // Hide stock search div when clicking outside
      $(document).on('click', function(event) {
        if (!$(event.target).closest('#stock_search_div').length) {
          $('#stock_search_div').removeClass('block').addClass('hidden');
        }
      });


      //change shiping address

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
