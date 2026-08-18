<x-mainpage-layout>
  @section('title', 'Quote Saved - '.config('app.name', 'Bodypoint'))

  <x-cart-nav />

  <section class="bg-[#F6F6F6] px-4 py-9">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <x-checkout-header page="complete" :intent="\App\Enums\CheckoutIntent::Quote" />

        <div class="">
          <h2 class="font-bold text-[#00707B] mb-2 text-center">Your Quote Is Saved</h2>
          <p class="text-[13px] font-normal leading-[19px] text-center mb-5">
            A copy has been emailed to you.
            @if ($expiresAt)
              This quote is valid until {{ $expiresAt->format('F j, Y') }}.
            @endif
            You can download it below, edit it, or find it again under Quotes at any time.
          </p>

          <div class="">
            <div class="card bg-white border border-gray-200 rounded-2xl shadow relative overflow-hidden">
              <div class="card-header px-6 py-4 flex flex-wrap gap-3 items-center justify-between border-b bg-[#00838f]">
                <h4 class="text-[#fff] text-left">Quote Date: {{ $quote->created_at ? $quote->created_at->format('F j, Y') : '' }}</h4>
                <h4 class="hidden sm:block text-[#fff] text-center">Quote Details</h4>
                <h4 class="text-[#fff] text-right">Quote No: {{ $quote->purchase_order_no }}</h4>
                <h4 class="text-[#fff] text-right">Valid Until: {{ $expiresAt ? $expiresAt->format('F j, Y') : '' }}</h4>
              </div>
              <div class="card-body">
                <div class="relative overflow-x-auto">
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <tbody>
                      @php $subtotal = 0; @endphp
                      @foreach ($quote->orderItem as $quoteitem)
                      <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <td class="px-6 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                          <div class="flex items-center gap-2">
                            <div class="">
                              <img src="<?php if (isset($quoteitem['Product']['Media'][0]['id'])) {
                                          echo url('storage/' . $quoteitem['Product']['Media'][0]['id'] . '/' . $quoteitem['Product']['Media'][0]['file_name']);
                                        } else {
                                          echo "/img/standard-img.png";
                                        } ?>" alt="product-img" class="w-[48px] h-[48px] object-cover" />
                            </div>
                            <div class="flex-1">
                              <p class="text-sm font-normal leading-[18px] mb-2">
                                <a href="{{ route('product', $quoteitem['Product']['slug'] ?? $quoteitem['Product']['name']) }}" target="_blank">
                                  <x-syspro-product-name :sku="$quoteitem['sku'] ?? null" :fallback="$quoteitem['Product']['name'] ?? ''" />
                                </a>
                              </p>
                              <span class="bg-[#E4E4E4] text-gray-800 text-[11px] leading-[18px] font-medium me-2 px-2.5 py-0.5 rounded-full">Qty:{{ $quoteitem['quantity'] }}</span>
                            </div>
                          </div>
                        </td>
                        <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] text-right">
                          ${{ $quoteitem['discount_price'] ? number_format($quoteitem['discount_price'] * $quoteitem['quantity'], 2, '.', ',') : 0 }}
                        </td>
                      </tr>
                      @php $subtotal += $quoteitem['discount_price'] * $quoteitem['quantity']; @endphp
                      @endforeach
                      <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <td class="min-w-[200px] p-4" colspan="2">
                          <div class="text-right">
                            <h3 class="text-2xl font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span> ${{ number_format($subtotal, 2, '.', ',') }}</h3>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="p-4 flex flex-wrap items-center justify-between gap-3">
                  <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">Continue Shopping</a>
                    <a href="{{ route('quotes') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">View All Quotes</a>
                    <a href="{{ route('quote.edit', $quote->id) }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center">Edit Quote</a>
                  </div>

                  {{-- One control for all three pricing tiers, in place of a button each. --}}
                  <form action="{{ route('pdf-download-quote', $quote->id) }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <label for="price_option" class="sr-only">Pricing to include</label>
                    <select name="price_option" id="price_option"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-[#00838f] focus:border-[#00838f] p-2.5">
                      <option value="all_price">All pricing</option>
                      <option value="msrp_primary">MSRP and primary</option>
                      <option value="msrp_only">MSRP only</option>
                    </select>
                    <button type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center">Download PDF</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</x-mainpage-layout>
