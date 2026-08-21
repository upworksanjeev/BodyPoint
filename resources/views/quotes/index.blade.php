@php
    $emergencyModeQuotes = \App\Models\EmergencyModeSetting::current()->is_enabled;
@endphp
<x-mainpage-layout>
    @if(session()->has('customer_po_number'))
    @php
    // dd(session()->get('customer_po_number') );
    @endphp

    @endif
    @section('title', 'Quotes - ' . config('app.name', 'Bodypoint'))
    <x-cart-nav />
    <section class="bg-[#F6F6F6] py-9 px-4">
        <header>
            <h2 class="text-lg text-[#00838f] font-bold text-center">
                All Quotes
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-center">
                List of all your Quotes
            </p>
            <p class="mt-2 text-sm text-gray-600 text-center">
                Quotes expire after 90 days.
            </p>
        </header>
        <div class="container mx-auto mt-9">
            <div class="max-w-screen-xl mx-auto px-4">
                <x-lookup.search-form
                    :action="route('quote-search')"
                    :clear-url="route('quotes')"
                    :sync-url="route('sync-account', getCustomerId())"
                    sync-label="Sync Quotes"
                    search-label="Search Quotes"
                    search-button-name="search_quote"
                    placeholder="Quote No/ BP Number"
                    :search="$search ?? ''"
                    :start-date="$start_date ?? ''"
                    :end-date="$end_date ?? ''"
                    :min-date="now()->subDays(\App\Http\Controllers\Quote\QuoteController::QUOTE_VALID_DAYS)->format('m/d/Y')"
                />
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
                                            $commentsForQuote = $quotesComments[$quote->id] ?? [];
                                            @endphp

                                            @foreach ($quote->OrderItem as $cartitem)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b">
                                                <td
                                                    class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] whitespace-nowrap border-e">
                                                    <x-syspro-product-name :sku="$cartitem->sku ?? null" :fallback="$cartitem->Product->name ?? ''" />
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
                                                @php
                                                $discount_price = ((float) $cartitem->discount_price == 0.00)
                                                ? $cartitem->price
                                                : $cartitem->discount_price;
                                                @endphp
                                                <td
                                                    class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
                                                    ${{ $discount_price ? number_format($discount_price * $cartitem->quantity, 2, '.', ',') : 0 }}
                                                </td>
                                            </tr>
                                            @php
                                            $comment = $commentsForQuote[$cartitem->id] ?? null;
                                            @endphp
                                            @if ($comment)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b bg-gray-50/70">
                                                <td colspan="6"
                                                    class="px-4 py-3 text-xs italic text-gray-600">
                                                    {{ $comment }}
                                                </td>
                                            </tr>
                                            @endif
                                            @php
                                            $subtotal += $discount_price * $cartitem->quantity;
                                            @endphp

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

                                    @php
                                    $customer = getCustomer();
                                    @endphp

                                    {{-- PDFs + Edit Quote: always full links; emergency mode never removes these. --}}
                                    <x-quote.pdf-download-control :quoteId="$quote->id" />

                                    <a href="{{ route('quote.edit', $quote->id) }}"
                                        class="py-2.5 px-5 text-sm font-medium w-full sm:w-auto text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-left justify-center">
                                        Edit Quote</a>

                                    @php
                                        $quoteMailtoHref = $emergencyModeQuotes ? \App\Support\EmergencyOrderMailto::buildQuoteMailtoHref($quote) : null;
                                        $quotePoTip = \App\Support\EmergencyOrderMailto::quotePlaceOrderDisabledTooltip((string) ($quote->purchase_order_no ?? ''));
                                        $quoteCopyText = $emergencyModeQuotes ? \App\Support\EmergencyOrderMailto::buildQuoteEmailBody($quote) : '';
                                    @endphp

                                    @if (!empty($quote->purchase_order_no) && $customer->hasPermissionTo('placeOrders'))
                                        @if ($emergencyModeQuotes)
                                            <x-emergency.faux-button label="Convert to order" :tooltip="$quotePoTip" primary wide />
                                            @if ($quoteMailtoHref)
                                                <a href="{{ $quoteMailtoHref }}"
                                                    class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-full sm:w-auto sm:min-w-[200px] items-center text-center whitespace-nowrap">
                                                    Email Order from this Quote
                                                </a>
                                            @else
                                                <x-emergency.faux-button label="Email Order from this Quote" :tooltip="\App\Support\EmergencyOrderMailto::emailOrderUnavailableTooltip()" primary wide />
                                            @endif
                                            @if ($quoteCopyText !== '')
                                                <button type="button" class="py-2 text-sm font-medium text-[#00838f] underline" data-bp-quote-copy="{{ base64_encode($quoteCopyText) }}" onclick="(function(b){var t=atob(b.getAttribute('data-bp-quote-copy'));navigator.clipboard.writeText(t).then(function(){if(window.toastr){toastr.success('Quote text copied');}}).catch(function(){});})(this)">Copy quote text</button>
                                            @endif
                                        @else
                                            <a href="{{ route('place-order-from-quote', $quote->id) }}"
                                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-full sm:w-[160px] items-center">
                                                Convert to order
                                            </a>
                                        @endif
                                    @endif

                                    @if ($emergencyModeQuotes)
                                        <div class="w-full flex justify-end mt-2 px-1">
                                            <p class="text-xs text-gray-600 max-w-xl text-right leading-snug">{!! \App\Support\EmergencyOrderMailto::partnerMailtoHelpHtml() !!}</p>
                                        </div>
                                    @endif

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
</x-mainpage-layout>
@if (session('downloadFile'))
@php
    $downloadFileUrl = session('downloadFile');
    session()->forget('downloadFile');
@endphp
<script>
    window.onload = function() {
        const downloadUrl = @json($downloadFileUrl);
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.download = 'quote.pdf';
        link.click();
    };
</script>
@endif