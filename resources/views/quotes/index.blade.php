<x-mainpage-layout>
    @if(session()->has('customer_po_number'))
        @php
       // dd(session()->get('customer_po_number') );
        @endphp
    
    @endif
    @section('title', 'Quotes - ' . config('app.name', 'Bodypoint'))
    <x-cart-nav />
    <section class="bg-[#fdffff] py-6 md:py-9 px-4">
        <header>
            <h2 class="text-lg text-[#00838f] font-bold text-center">
                All Quotes
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-center">
                List of all your Quotes
            </p>
        </header>
        <div class="container mx-auto mt-9">
            <div class="lg:max-w-screen-xl mx-auto">
                <form action="{{ route('quote-search') }}" method="post">
                    @csrf
                    <div class="lg:grid gap-6 mb-6 lg:grid-cols-3">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search By:</label>
                            <input type="text" id="search_input" name="search_input"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Quote No/ BP Number" value="{{ $search ?? '' }}" />
                        </div>
                        <div class="mt-4 lg:mt-0">
                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">Order Date:
                            </label>
                            <div date-rangepicker datepicker-max-date="{{ now()->format('m/d/Y') }}" class="lg:flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.date />
                                    </div>
                                    <input name="start_date" id="start_date" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                        placeholder="Select date start" value="{{ $start_date ?? '' }}">
                                </div>
                                <span class="sm:mx-4 text-gray-500 text-center my-2 inline-block sm:my-0">to</span>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.date />
                                    </div>
                                    <input name="end_date" id="end_date" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                        placeholder="Select date end" value="{{ $end_date ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-baseline md:items-center flex-wrap xl:flex-nowrap mt-4 md:mt-5 gap-4 sm:gap-2">
                            <button type="submit" name="search_quote"
                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-full sm:w-[145px] items-left">Search
                                Quote</button>
                            <a href="{{ route('quotes') }}"
                                class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-right justify-center w-full sm:w-[145px]">Clear
                                Search</a>
                            <button type="submit" name="download"
                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-full sm:w-[145px]">Download</button>
                            
                        </div>
                    </div>
                </form>
                <a href="{{ route('sync-account', getCustomerId()) }}"
                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-full sm:w-[145px]">Sync Quotes</a>
                <div class="relative overflow-x-auto sm:rounded-2xl mt-5 md:mt-10" id="order_list">
                    <div id="accordion-collapse" data-accordion="collapse">
                        @if (!$quotes->isEmpty())
                            @foreach ($quotes as $quote)
                                <h2 id="accordion-collapse-heading-{{ $quote->id }}" class="">
                                    <button type="button"
                                        class="flex flex-wrap items-center justify-center sm:justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-[16px] focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 gap-3"
                                        data-accordion-target="#accordion-collapse-body-{{ $quote->id }}"
                                        aria-expanded="true"
                                        aria-controls="accordion-collapse-body-{{ $quote->id }}">
                                        <span>Quote No: {{ $quote->purchase_order_no }}</span>
                                        @if (!empty($quote->status))
                                            <span>Quote Status: {{ $quote->order_status }}</span>
                                        @endif
                                        <span class="text-center">Quote Date:
                                            {{ date('F j, Y', strtotime($quote->created_at)) }}</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-{{ $quote->id }}" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-{{ $quote->id }}">
                                    <div class="p-5 border border-b-0 border-gray-200">
                                        <div class="overflow-auto w-full">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                                <thead class="bg-[#00838f] font-semibold text-sm text-white">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-4 py-3 font-bold border-e border-gray-500">
                                                            Product name
                                                        </th>
                                                        <th scope="col"
                                                            class="px-4 py-3 font-bold border-e border-gray-500">
                                                            Stock Code
                                                        </th>
                                                        <th scope="col"
                                                            class="px-4 py-3 font-bold border-e border-gray-500">
                                                            Marked For
                                                        </th>
                                                        <th scope="col"
                                                            class="px-4 py-3 font-bold border-e border-gray-500">
                                                            Qty.
                                                        </th>
                                                        <th scope="col"
                                                            class="px-4 py-3 font-bold border-e border-gray-500">
                                                            Unit
                                                        </th>
                                                        <th scope="col" class="px-4 py-3 font-bold">
                                                            Total
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $subtotal = 0;
                                                        $tax = 0.0;
                                                    @endphp

                                                    @foreach ($quote->OrderItem as $cartitem)
                                                        <tr class="odd:bg-white even:bg-gray-50 border-b">
                                                            <td
                                                                class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] whitespace-nowrap border-e">
                                                                {{ $cartitem->Product->name }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                                {{ $cartitem->sku }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                                {{ $cartitem->marked_for }}
                                                            </td>
                                                            <td
                                                                class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                                {{ $cartitem->quantity }}
                                                            </td>

                                                            <td
                                                                class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                                EA
                                                            </td>

                                                            <td
                                                                class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
                                                                ${{ $cartitem->discount_price ? number_format($cartitem->discount_price * $cartitem->quantity, 2, '.', ',') : 0 }}
                                                            </td>
                                                        </tr>
                                                        <?php $subtotal += $cartitem->discount_price * $cartitem->quantity; ?>
                                                    @endforeach
                                                    <tr class="odd:bg-white even:bg-gray-50 border-b">

                                                        <td class="w-4 p-4" colspan="2">
                                                            <div class="text-left"><span>BP Number:
                                                                    {{ $quote->bp_number }}</span></div>
                                                        </td>

                                                        <td class="w-4 p-4" colspan="8">
                                                            <div class="text-right">
                                                                <h3 class="text-2xl font-normal text-[#000]"
                                                                    id="subtotal"><span
                                                                        class="font-bold">Subtotal:</span>
                                                                    ${{ number_format($subtotal, 2, '.', ',') }}</h3>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="flex justify-end align-center mt-4 gap-4 flex-wrap">
                                            <a href="{{ route('pdf-download-quote', $quote->id) }}?price_option=msrp_only"
                                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left w-full sm:w-auto">Download
                                                MSRP</a>
                                            <a href="{{ route('pdf-download-quote', $quote->id) }}?price_option=msrp_primary"
                                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left w-full sm:w-auto">Download
                                                MSRP and Primary Price</a>
                                            <a href="{{ route('pdf-download-quote', $quote->id) }}?price_option=all_price"
                                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left w-full sm:w-auto">Download
                                                All Pricing</a>
                                            @php
                                                $customer = getCustomer();
                                            @endphp
                                            @if (!empty($quote->purchase_order_no) && $customer->hasPermissionTo('placeOrders'))
                                                <form method="POST" id="form_1{{ $quote->purchase_order_no }}"
                                                    action="{{ route('place-order', $quote->purchase_order_no) }}"
                                                    class="place_order_form w-full sm:w-auto">
                                                    @csrf
                                                    <input type="hidden" name="customer_po_number"
                                                        id="p_o_1{{ $quote->purchase_order_no }}">
                                                    <input type="hidden" name="is_duplicate"
                                                        id="is_duplicate_1{{ $quote->purchase_order_no }}">
                                                        {{ request('customer_po_number') }}
                                                    <button
                                                        onclick="popOpen(event, {{ '1' . $quote->purchase_order_no }})"
                                                        class="place_order_button py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-full sm:w-[160px] items-left"
                                                        type="button">Place Order</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('quote.edit', $quote->id) }}"
                                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left w-full sm:w-auto">
                                                Edit Quote</a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-4">
                                {{ $quotes->links() }} {{-- This generates pagination links --}}
                            </div>
                        @else
                            <div>
                                <h1>No Quotes Found</h1>
                        @endif
                    </div>
                </div>
                <div class="pt-4 md:pt-6 pb-2 text-right">
                    <a href="{{ route('home') }}"
                        class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2">Continue
                        Shopping
                        <x-icons.next-arrow /></a>
                </div>
            </div>
        </div>
    </section>

    <x-modals.po-number 
        save="save-po-number" 
        cross="close-cross-po-modal" 
        name="customer-po-number"
        id="po-number-modal" 
        class="close-po-number-modal" 
        form="confirm-order-form" 
        :cart=[]
        action="{{ route('confirm-order') }}" 
    />

    @push('other-scripts')
        <script>
         var orderID = '';    
        var customerPoNumber = @json(session('customer_po_number'));
        var error = @json(session('error'));
        orderID = '1'+@json(session('order_id'));
        
        var showPoModal = false;
        if (error && typeof error === "string" && error.includes('Duplicate')) {
            showPoModal = true;
        }
        if(showPoModal){
            $('#error_alert_po').text(error);
            $('#error_alert_po').show();
            $('#po-number-modal').show();
            $('#customer-po-number').val(customerPoNumber);
            $('#duplicate-confirmation').show();
                $('#po-number-modal').css({
                    'display': 'flex',
                    'background-color': 'rgb(0 0 0 / 56%)'
                });
        }
           

            function popOpen(e, order_id) {
                e.preventDefault();
                orderID = order_id;
                $('.place_order_button').prop('disabled', true);
                const po_number = $('#customer-po-number').val();
                if (po_number !== "" && po_number !== null) {
                    $('#form_'+orderID).submit();
                    $("#fullLoader").css("display", "flex");
                }else{
                    $("#fullLoader").css("display", "none");
                    $('.place_order_button').prop('disabled', false);
                    $('#po-number-modal').show();
                    $('#po-number-modal').css({
                        'display': 'flex',
                        'background-color': 'rgb(0 0 0 / 56%)'
                    });
                }
            }
            $(document).on('click','#save-po-number',function(event){
                event.preventDefault();
                $('.place_order_button').prop('disabled', true);
                const po_number = $('#customer-po-number').val();
                const isDuplicate = $('#agree-duplicate').is(":visible") ? $('#agree-duplicate').val() : null;
                if (po_number == "" || po_number == null) {
                    toastr.error('Customer PO Number is Required');
                    $('.place_order_button').prop('disabled', false);
                    $("#fullLoader").css("display", "none");
                }else {
                    $('#po-number-modal').hide();
                    $('#p_o_'+orderID).val(po_number);
                    $('#is_duplicate_'+orderID).val(isDuplicate);
                    $('#form_'+orderID).submit();
                    $("#fullLoader").css("display", "flex");
                }
            });
            $(document).on('click', '.close-po-number-modal, .close-cross-po-modal', function() {
                $('#po-number-modal').hide();
            });
        </script>
    @endpush
</x-mainpage-layout>
@if (session('downloadFile'))
    <script>
        window.onload = function() {
            const downloadUrl = "{{ session('downloadFile') }}";
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = 'quote.pdf';
            link.click();
            {{ session()->forget('downloadFile') }}
        };
    </script>
@endif
