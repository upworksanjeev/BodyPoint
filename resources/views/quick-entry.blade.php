@php
    $customer = getCustomer();
@endphp
<x-mainpage-layout>
  <x-cart-nav />
  <section class="bg-[#fdffff] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="pb-6">
          <p class="text-[20px] font-normal leading-[24px] mb-4">Bodypoint Quick Order Instructions</p>
          <ol class="text-sm font-normal text-[#000] leading-[29px]">
            <li>1. Type part number to see a list from which to choose, and click on your desired item.</li>
            <li>2. Enter quantity.</li>
            <li>3. Click the “Add to Cart” Button.</li>
            <li>4. Repeat steps 1-3 until you have entered all your desired items, and can see the accompanying prices.
            </li>
            <li>5. Click “Go to Shopping Cart”, and follow the checkout / quote process.</li>
          </ol>
        </div>
        <div class="flex items-baseline lg:items-center lg:flex-row flex-col gap-4 justify-start mb-6">
          <div class="lg:w-[35%] w-full">

            <div class="relative">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <x-icons.search />

              </div>
              <input type="search" id="myInput" onkeyup="myFunction()" class="block w-full p-3 pe-0 ps-10 text-sm text-[#000] border border-[#000] rounded-full bg-white focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#000]" placeholder="Enter Stock Code" required />

              <button type="button" class="text-white absolute end-2.5 top-0 bottom-0 right-0 bg-[#2F2F2F] hover:bg-[#000] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-e-full text-sm px-5 py-3" onclick="clearStock()">Clear</button>
              <div id="stock_search_div" class="hidden">
                <div class="h-full min-h-[250px] max-h-[360px] overflow-y-auto absolute top-45 w-full left-0 z-10">
                <table id="myTable" class="rounded-xl shadow-lg max-h-[360px] overflow-y-auto bg-white">
                  <thead class="header top-0">
                    <tr>
                      <th scope="col" style="width: 30%;" class="text-white">Stock Code</th>
                      <th scope="col" style="width: 70%;" class="text-white">Name</th>
                    </tr>
                  </thead>
                  <tbody id="stock_search_table">
                  </tbody>

                </table>
            </div>
              </div>
            </div>
            <input id="selected_product_id" type="hidden">

          </div>

          <div class="flex items-center gap-3">
            <label class="text-md font-normal text-[#000] leading-[18px]">Qty</label>
            <input type="number" id="qty" class="block w-full py-2 px-3 text-sm text-[#000] border border-[#000] rounded-full bg-white min-w-[72px] max-w-[72px] text-center" placeholder="01" />
          </div>
          <div>
            @if($customer->hasPermissionTo('addToCart'))
                <button type="button" onclick="addToCart()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">
                <div class="w-[20px] h-[20px]">
                    <x-icons.basket />
                </div>
                Add To Cart
                </button>
            @endif
          </div>
        </div>

        <div class="relative overflow-x-auto shadow-md rounded-2xl">

          <x-cart-product-list page="cart" :cart="$cart" />
        </div>
      </div>
    </div>
  </section>
  @push('other-scripts')
  <script>
    function myFunction() {
      $("#stock_search_div").addClass("hidden");
      $("#stock_search_div").removeClass("block");
      $.ajax({
        url: "{{ route('search-product') }}",
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          keys: $('#myInput').val(),
        },
        success: function(response) {
          $('#stock_search_table').html(response);
          if (response != '') {
            $("#stock_search_div").addClass("block");
            $("#stock_search_div").removeClass("hidden");
          }
        }
      });
    }

    function clearStock() {
      $("#stock_search_div").addClass("hidden");
      $("#stock_search_div").removeClass("block");
      $('#myInput').val('');
      $('#selected_product_id').val('');
      $('#qty').val('');
    }

    function chooseProduct(sku, product_id) {
      $("#stock_search_div").addClass("hidden");
      $("#stock_search_div").removeClass("block");
      $('#myInput').val(sku);
      $('#selected_product_id').val(product_id);
      $('#qty').val(1);
    }

    function addToCart(sku, product_id) {
        $('#error_alert').remove();
      if ($('#selected_product_id').val() == '') {
        $('#myInput').addClass('focus:ring-red-500 focus:border-red-500');
        $('#myInput').removeClass('focus:ring-blue-500 focus:border-blue-500');
        $('#myInput').focus();
      } else if ($('#qty').val() == '') {
        $('#qty').addClass('focus:ring-red-300');
        $('#qty').removeClass('focus:ring-blue-300');
        $('#qty').focus();
      } else {
        $('#myInput').removeClass('focus:ring-red-500 focus:border-red-500');
        $('#myInput').addClass('focus:ring-blue-500 focus:border-blue-500');
        $('#qty').removeClass('focus:ring-red-300');
        $('#qty').addClass('focus:ring-blue-300');
        $.ajax({
          url: "{{ route('add-to-cart') }}",
          type: 'POST',
          data: {
            "_token": "{{ csrf_token() }}",
            product_id: $('#selected_product_id').val(),
            qty: $('#qty').val(),
          },
          success: function(response) {
            if(response.success == false){
                toastr.error(response.message);
                return;
            }
            $('#tbody_data').html(response);
            /* update header cart count*/
            $.ajax({
            url: "{{ route('get-cart-count') }}",
            type: 'GET',
            success: function(response) {
                $('#cart_count_div').html(response);
            }
            });

            $('#myInput').val('');
            $('#selected_product_id').val('');
            $('#qty').val('');
          }
        });
      }
    }

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#stock_search_div').length) {
            $('#stock_search_div').removeClass('block').addClass('hidden');
        }
    });
  </script>
  @endpush

</x-mainpage-layout>
