@props([
    'variant',
    'order' => null,
    'quote' => null,
    'processedItems' => [],
    'expiresAt' => null,
    'canConvertToOrder' => false,
])

@php
    $isOrder = $variant === 'order';
    $intent = $isOrder ? \App\Enums\CheckoutIntent::Order : \App\Enums\CheckoutIntent::Quote;
@endphp

<x-mainpage-layout>
    @section('title', ($isOrder ? 'Order Complete' : 'Quote Saved') . ' - ' . config('app.name', 'Bodypoint'))

    <x-cart-nav />

    <section class="bg-[#F6F6F6] px-4 py-9">
        <div class="container mx-auto">
            <div class="max-w-screen-xl mx-auto">
                <x-checkout-header page="complete" :intent="$intent" />

                @if ($isOrder)
                    <h2 class="font-bold text-[#00707B] mb-2 text-center">Thank You For Your Purchase!</h2>
                    @if (!empty($order->converted_from_quote_no))
                        <p class="text-[13px] font-normal leading-[19px] text-center mb-5 text-gray-700">
                            This order was converted from quote <span class="font-semibold">{{ $order->converted_from_quote_no }}</span>.
                        </p>
                    @endif
                @else
                    <h2 class="font-bold text-[#00707B] mb-2 text-center">Your Quote Is Saved</h2>
                    <p class="text-[13px] font-normal leading-[19px] text-center mb-5">
                        A copy has been emailed to you.
                        @if ($expiresAt)
                            This quote is valid until {{ $expiresAt->format('F j, Y') }}.
                        @endif
                        You can download it below, edit it, or find it again under Quotes at any time.
                    </p>
                @endif

                <div class="card bg-white border border-gray-200 rounded-2xl shadow relative overflow-hidden">
                    <div class="card-header px-6 py-4 flex flex-wrap gap-3 items-center justify-between border-b bg-[#00838f]">
                        @if ($isOrder)
                            <h4 class="text-[#fff] text-left">Order Date: {{ $order->created_at ? $order->created_at->format('F j, Y') : '' }}</h4>
                            <h4 class="hidden sm:block text-[#fff] text-center">Order Details</h4>
                            <div class="flex flex-wrap items-center justify-end gap-2 ml-auto">
                                @if ($order->status)
                                    <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white">
                                        {{ $order->order_status }}
                                    </span>
                                @endif
                                <h4 class="text-[#fff] text-right">Order No: {{ $order->purchase_order_no }}</h4>
                            </div>
                            @if ($order->customer_po_number)
                                <h4 class="text-[#fff] text-right w-full sm:w-auto">Customer PO No: {{ $order->customer_po_number }}</h4>
                            @endif
                        @else
                            <h4 class="text-[#fff] text-left">Quote Date: {{ $quote->created_at ? $quote->created_at->format('F j, Y') : '' }}</h4>
                            <h4 class="hidden sm:block text-[#fff] text-center">Quote Details</h4>
                            <h4 class="text-[#fff] text-right">Quote No: {{ $quote->purchase_order_no }}</h4>
                            <h4 class="text-[#fff] text-right">Valid Until: {{ $expiresAt ? $expiresAt->format('F j, Y') : '' }}</h4>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <tbody>
                                    @php $subtotal = 0; @endphp

                                    @if ($isOrder)
                                        @if (!empty($processedItems))
                                            @foreach ($processedItems as $processedItem)
                                                @php
                                                    $cartitem = $processedItem['orderItem'];
                                                    $comment = $processedItem['comment'] ?? null;
                                                @endphp
                                                <x-checkout.completion-line-item :item="$cartitem" :comment="$comment" />
                                                @php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; @endphp
                                            @endforeach
                                        @else
                                            @foreach ($order->orderItem as $cartitem)
                                                <x-checkout.completion-line-item :item="$cartitem" />
                                                @php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @foreach ($quote->orderItem as $quoteitem)
                                            <x-checkout.completion-line-item :item="$quoteitem" />
                                            @php $subtotal += $quoteitem['discount_price'] * $quoteitem['quantity']; @endphp
                                        @endforeach
                                    @endif

                                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                                        <td class="min-w-[200px] p-4" colspan="2">
                                            <div class="text-right">
                                                <h3 class="text-2xl font-normal text-[#000]" id="subtotal">
                                                    <span class="font-bold">Subtotal:</span> ${{ number_format($subtotal, 2, '.', ',') }}
                                                </h3>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4 flex flex-wrap items-center justify-between gap-3 border-t">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">Continue Shopping</a>

                                @if ($isOrder)
                                    @if ($order->purchase_order_no)
                                        <a href="{{ route('order', ['search_input' => $order->purchase_order_no]) }}"
                                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">
                                            Track this order
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('quotes') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">View All Quotes</a>
                                    <a href="{{ route('quote.edit', $quote->id) }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">Edit Quote</a>
                                    @if ($canConvertToOrder)
                                        <a href="{{ route('place-order-from-quote', $quote->id) }}"
                                            class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center">
                                            Convert to order
                                        </a>
                                    @endif
                                @endif
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                @if ($isOrder)
                                    <form action="{{ route('receipt-download') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center">Download Order Confirmation</button>
                                    </form>
                                @else
                                    <x-quote.pdf-download-control :quoteId="$quote->id" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-mainpage-layout>
