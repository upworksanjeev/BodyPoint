<x-mainpage-layout>
    @section('title', 'Checkout - '.config('app.name', 'Bodypoint'))
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div id="error_alert" x-data="{ open: true }" x-show="open" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert">
        {!! $error !!}
        <input type="hidden" id="error-messages" value='@json($errors->all())'>
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
                    <div class="card-body p-6 border-t order-buttons">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('quote') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]"> Save a Quote</a>
                            <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>
                            <button id="confirm-order" type="button" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Confirm Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Modal -->
    <x-modals.po-number
    save="save-po-number"
    cross="close-cross-po-modal"
    name="customer-po-number"
    id="po-number-modal"
    class="close-po-number-modal"
    form="confirm-order-form"
    :cart="$cart"
    action="{{ route('confirm-order') }}"
    />

    @push('other-scripts')
    <script>
        var error =  @json(session('error'));
        
        var showPoModal = false;
        if (error && typeof error === "string" && error.includes('Duplicate Purchase Order')) {
            showPoModal = true;
        }
        console.log(showPoModal);
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
        if(showPoModal){
            $('#error_alert_po').text(error);
            $('#error_alert_po').show();
            //var confirmationBox = document.getElementById("duplicate-confirmation");
            //confirmationBox.style.display = "block";
            $('#po-number-modal').show();
            $('#duplicate-confirmation').show();
                $('#po-number-modal').css({
                    'display': 'flex',
                    'background-color': 'rgb(0 0 0 / 56%)'
                });
        }
        $(document).on('click', '#confirm-order', function(event) {
            event.preventDefault();
            const po_number = $('#customer-po-number').val();
            if (po_number !== "" && po_number !== null) {
                $('#confirm-order-form').submit();
            }else{
                $('#po-number-modal').show();
                $('#po-number-modal').css({
                    'display': 'flex',
                    'background-color': 'rgb(0 0 0 / 56%)'
                });
            }
        });

        $(document).on('click','#save-po-number',function(){
            const po_number = $('#customer-po-number').val();
            if (po_number == "" || po_number == null) {
                toastr.error('Customer PO Number is Required');
            }else {
                $('.po-number-div').remove();
                $('.order-buttons').before('<div class="po-number-div flex justify-end gap-3 flex-wrap px-6 pb-6">' +
                    '<div class="min-w-[250px]">' +
                        '<span class="text-sm text-[#000] font-bold leading-[17px]">Your PO Number Is:</span>' +
                    '</div>' +
                    '<div class="min-w-[100px] text-right">' +
                        '<span class="font-bold mr-2">' + po_number + '</span> ' +
                        '<button data-modal-target="po-number-modal" data-modal-toggle="po-number-modal" class="edit-customer-po-number" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>' +
                    '</div>' +
                '</div>');
                $('#po-number-modal').hide();
                $('#confirm-order-form').submit();
            }
        });


        $(document).on('click', '.edit-customer-po-number', function() {
            $('#po-number-modal').show();
            $('#po-number-modal').css({
                'display': 'flex',
                'background-color': 'rgb(0 0 0 / 56%)'
            });
        });

        $(document).on('click', '.close-po-number-modal, .close-cross-po-modal', function() {
            $('#po-number-modal').hide();
        });

    </script>
    @endpush

</x-mainpage-layout>
