<table class="w-full text-sm text-left rtl:text-right text-gray-500">
    <thead class="bg-[#00838f] font-semibold text-sm text-white">
        <tr>
            <!--th scope="col" class="p-4 pe-0">
                  <div class="flex items-center">
                    <input id="checkbox-all-search" type="checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                  </div>
                </th-->
            <th scope="col" class="px-4 py-3 font-bold">
                Product name
            </th>
            <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">
                Stock Code
            </th>
            <th scope="col" class="px-4 py-3 font-bold">
                MSRP
            </th>
            <th scope="col" class="px-4 py-3 font-bold">
                Primary Discount
            </th>
            <th scope="col" class="px-4 py-3 font-bold">
                After Secondary Discount
            </th>
            <th scope="col" class="px-4 py-3 font-bold">
                Qty.
            </th>
            <th scope="col" class="px-4 py-3 font-bold">
                Net Price
            </th>
            <th scope="col" class="px-4 py-3 font-bold">
                Unit
            </th>
            <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">
                Item Total
            </th>
            <th scope="col" class="px-4 py-3">

            </th>
        </tr>
    </thead>
    <tbody id="tbody_data">
        <x-cart.quote-product-list :page="$page" :quote="$quote" />
    </tbody>
</table>

@push('other-scripts')
    <script>
        /* update cart items like add/delete item */
        function updateProduct(option, cartitem_id) {
            $.ajax({
                url: "{{ route('update-quote-item') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    cart_item_id: cartitem_id,
                    option: option,
                },
                success: function(response) {
                    $('#tbody_data').html(response);
                    /* update header cart count*/
                    // $.ajax({
                    //     url: "{{ route('get-cart-count') }}",
                    //     type: 'GET',
                    //     success: function(response) {
                    //         $('#cart_count_div').html(response);
                    //     }
                    // });
                },
                error: function(xhr) {

                }
            });
        }

        /* Delete All cart items */
        function clearCart(cart_id) {
            $.ajax({
                url: "{{ route('delete-cart') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    cart_id: cart_id,
                },
                success: function(response) {
                    $('#tbody_data').html(response);
                    /* update header cart count*/
                    $.ajax({
                        url: "{{ route('get-cart-count') }}",
                        type: 'GET',
                        success: function(response) {
                            $('#cart_count_div').html(response);
                        }
                    });
                },
                error: function(xhr) {

                }
            });
        }

        /* update cart item details */
        function updateQuoteItem(cart_item_id) {
            $.ajax({
                url: "{{ route('update-quote-item-marked') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    cart_item_id: cart_item_id,
                    marked_for: $('#marked_for_' + cart_item_id).val(),
                },
                success: function(response) {

                },
                error: function(xhr) {

                }
            });
        }

        function updateQuantity(option, cart_item_id) {
            var quantity = $('#quantity_input_' + cart_item_id).val();
            var old_quantity = $('#quantity_input_' + cart_item_id).attr("data-old-quantity");
            if (quantity == 0) {
                toastr.error('Quantity cannot be zero. Please enter a valid quantity.');
                $('#quantity_input_' + cart_item_id).val(old_quantity);
                return;
            }
            if (quantity != 0 || quantity != "") {
                $.ajax({
                    url: "{{ route('update-quote-item') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        cart_item_id: cart_item_id,
                        option: option,
                        quantity: quantity
                    },
                    success: function(response) {
                        $('#tbody_data').html(response);
                        $.ajax({
                            url: "{{ route('get-cart-count') }}",
                            type: 'GET',
                            success: function(response) {
                                $('#cart_count_div').html(response);
                            }
                        });
                    },
                    error: function(xhr) {

                    }
                });
            }
        }
    </script>
@endpush
