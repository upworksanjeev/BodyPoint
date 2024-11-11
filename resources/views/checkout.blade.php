<x-mainpage-layout>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div id="error_alert" x-data="{ open: true }" x-show="open" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert">
        {!! $error !!}
        <button @click="open = false" type="button" class="absolute top-0 bottom-0 right-0 mr-4 mt-2 text-red-800 focus:outline-none" aria-label="Close">&times;</button>
    </div>
    @endforeach
    </div>
    @endif
    <x-cart-nav />

    <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
        <div class="container mx-auto">
            <div class="max-w-screen-xl mx-auto">
                <x-checkout-header page="checkout" />

                <div class="pb-6">
                    <p class="text-[13px] font-normal leading-[19px] text-center">Your order summary is provided below. Please review carefully and click confirm order to process your order. Click cancel to return to your shopping cart.</p>
                </div>

                <div class="card w-full max-w-[920px] m-auto bg-white border border-gray-200 rounded-2xl shadow mb-4">
                    <div class="card-header px-6 py-2 bg-[#00838f] rounded-t-xl">
                        <h4 class="text-[#fff]">Order Information</h4>
                    </div>
                    <div class="card-body p-6">
                        <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                            <li class="flex items-start gap-5">
                                <span class="text-sm text-[#000] font-normal leading-[17px]">Account</span>
                                <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $user->email }}</span>
                            </li>
                            {{-- <li class="flex items-center gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Purchase Order #:</span>
                <input class="py-[2px] px-5 text-sm font-medium focus:outline-none rounded-full border border-[#31BA32] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center" value="" name="purchase_no" id="purchase_no" onchange="changePurchaseNo({{ $cart[0]['id'] }})">
                            </li> --}}
                        </ul>
                    </div>
                    <x-shipping-info :cart="$cart" :user="$user" :userDetail="$user_detail" />
                    <x-cart.final-checkout-list :cart="$cart" />
                    <div class="card-body p-6 border-t">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('quote') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]"> Save a Quote</a>

                            <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>
                            <button type="submit" data-modal-target="po-number-modal" data-modal-toggle="po-number-modal" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Confirm Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main modal -->
    <div id="po-number-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        CUSTOMER PO NUMBER
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="po-number-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form id="confirm-order-form" action="{{ route('confirm-order') }}" method="POST">
                        <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                        <input type="hidden" name="cart_id" value="{{ $cart[0]['id'] }}" id="order-cart-id">
                        <input type="text" name="po_number" placeholder="Enter PO Number" id="customer-po-number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button data-modal-hide="po-number-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff]  focus:z-10 focus:ring-4 focus:ring-gray-100 w-[160px]">Cancel</button>
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]" id="confirm-order">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    @push('other-scripts')
    <script>
        function changePurchaseNo(cart_id) {
            var p_num = $("#purchase_no").val();
            $("#purchase_order_no").val(p_num);
            $.ajax({
                url: "{{ route('update-purchase-no') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    cart_id: cart_id,
                    purchase_order_no: p_num,
                },
                success: function(response) {

                }
            });
        }

        $(document).on('click', '#confirm-order', function(event) {
            event.preventDefault();
            const po_number = $('#customer-po-number').val();
            if (po_number == "" || po_number == null) {
                toastr.error('Customer PO Number is Required');
            } else {
                $('#confirm-order-form').submit();
            }

        });

    </script>
    @endpush

</x-mainpage-layout>
