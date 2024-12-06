<x-mainpage-layout>
    <x-cart-nav />
    <section class="bg-[#F6F6F6] py-9">
        <header>
            <h2 class="text-lg text-[#00838f] font-bold text-center">
                All Quotes
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-center">
                List of all your Quotes
            </p>
        </header>
        <div class="container mx-auto mt-9">
            <div class="max-w-screen-xl mx-auto">
                <form action="{{ route('quote-search') }}" method="post">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search By:</label>
                            <input type="text" id="search_input" name="search_input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Quote No/ BP Number" value="{{ $search??'' }}" />
                        </div>
                        <div>
                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">Order Date: </label>
                            <div date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.date />
                                    </div>
                                    <input name="start_date" id="start_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start" value="{{ $start_date??'' }}">
                                </div>
                                <span class="mx-4 text-gray-500">to</span>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.date />
                                    </div>
                                    <input name="end_date" id="end_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end" value="{{ $end_date??'' }}">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5 gap-2">
                            <button type="submit" name="search_quote" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-[160px] items-left">Search Quote</button>
                            <a href="{{ route('quotes') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-right justify-center w-[160px]">Clear Search</a>
                            <button type="submit" name="download" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Download</button>
                        </div>
                    </div>
                </form>
                <div class="relative overflow-x-auto sm:rounded-2xl mt-10" id="order_list">
                    <div id="accordion-collapse" data-accordion="collapse">
                        @if(!$quotes->isEmpty())
                            @foreach ($quotes as $quote)
                                <h2 id="accordion-collapse-heading-{{ $quote->id }}" class="">
                                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-[16px] focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 gap-3" data-accordion-target="#accordion-collapse-body-{{ $quote->id }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $quote->id }}">
                                        <span>Quote No: {{ $quote->purchase_order_no }}</span>
                                        @if(!empty($quote->status))
                                            <span>Quote Status: {{ $quote->order_status }}</span>
                                        @endif
                                        <span class="text-center">Quote Date: {{ date('F j, Y',strtotime($quote->created_at)) }}</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-{{ $quote->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $quote->id }}">
                                    <div class="p-5 border border-b-0 border-gray-200">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                            <thead class="bg-[#00838f] font-semibold text-sm text-white">
                                                <tr>
                                                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                                                        Product name
                                                    </th>
                                                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                                                        Stock Code
                                                    </th>
                                                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                                                        Marked For
                                                    </th>
                                                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                                                        Qty.
                                                    </th>
                                                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
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
                                                    $tax = 0.00;
                                                @endphp

                                                @foreach ($quote->OrderItem as $cartitem)
                                                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                                                        <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] whitespace-nowrap border-e">
                                                            {{ $cartitem->Product->name }}
                                                        </td>
                                                        <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                            {{ $cartitem->sku }}
                                                        </td>
                                                        <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                            {{ $cartitem->marked_for }}
                                                        </td>
                                                        <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                            {{ $cartitem->quantity }}
                                                        </td>

                                                        <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                                                            EA
                                                        </td>

                                                        <td class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
                                                            ${{ $cartitem->discount_price ? number_format($cartitem->discount_price * $cartitem->quantity, 2, '.', ',') : 0 }}
                                                        </td>
                                                    </tr>
                                                <?php $subtotal += $cartitem->discount_price * $cartitem->quantity; ?>
                                                @endforeach
                                                <tr class="odd:bg-white even:bg-gray-50 border-b">

                                                    <td class="w-4 p-4" colspan="2">
                                                        <div class="text-left"><span>BP Number: {{ $quote->bp_number }}</span></div>
                                                    </td>

                                                    <td class="w-4 p-4" colspan="8">
                                                        <div class="text-right">
                                                            <h3 class="text-2xl font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span> ${{ number_format($subtotal, 2, '.', ',') }}</h3>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="flex justify-end align-center mt-4 gap-4">
                                            <a href="{{ route('pdf-download-quote', $quote->id) }}?price_option=msrp_only" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left">Download MSRP</a>
                                            <a href="{{ route('pdf-download-quote', $quote->id) }}?price_option=msrp_primary" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left">Download MSRP and Primary Price</a>
                                            <a href="{{ route('pdf-download-quote', $quote->id) }}?price_option=all_price" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center items-left">Download All</a>
                                            @php
                                                $customer = getCustomer();
                                            @endphp
                                            @if(!empty($quote->purchase_order_no) && $customer->hasPermissionTo('placeOrder'))
                                                <form method="POST" action="{{ route('place-order',$quote->purchase_order_no) }}" class="place_order_form">
                                                    @csrf
                                                    <button class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-[160px] items-left" type="submit">Place Order</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div><h1>No Quotes Found</h1>
                        @endif
                    </div>
                </div>
                <div class="py-6 text-right">
                    <a href="{{ route('home') }}" class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2">Continue Shopping
                        <x-icons.next-arrow /></a>
                </div>
            </div>
        </div>
    </section>
</x-mainpage-layout>
@if(session('downloadFile'))
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
