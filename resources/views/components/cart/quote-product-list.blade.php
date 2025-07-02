<?php $subtotal = 0; ?>
@if(isset($quote))
@foreach ($quote->orderItem as $cartitem)
<tr class="odd:bg-white even:bg-gray-50 border-b" id="tr_{{ $cartitem['id'] }}">
  <!--td class="w-4 p-4 pe-0">
                  <div class="flex items-center">
                    <input id="checkbox-table-search-1" type="checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                  </div>
                </td-->
  <td scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap">
    <div class="flex items-center gap-2">
      <div class=""><a href="{{ route('product',$cartitem['Product']['slug']??$cartitem['Product']['name']) }}" target="_blank">
          <img src="<?php if (isset($cartitem['Product']['Media'][0]['id'])) {
                      echo url('storage/' . $cartitem['Product']['Media'][0]['id'] . '/' . $cartitem['Product']['Media'][0]['file_name']);
                    } else {
                      echo "/img/standard-img.png";
                    } ?>" alt="product-img" class="w-[48px] h-[48px] object-cover" /></a>
      </div>
      <div class="flex-1">
        <p class="text-sm font-normal leading-[18px] mb-2"><a href="{{ route('product',$cartitem['Product']['slug']??$cartitem['Product']['name']) }}" target="_blank">{{ $cartitem['Product']['name'] }}</a></p>
        <div class="flex gap-2">
          <label class="text-sm font-normal leading-4 text-[#525252]">Marked <br />
            for:</label>
          <input type="text" id="marked_for_{{ $cartitem['id'] }}" value="{{ $cartitem['marked_for'] }}" onchange="updateQuoteItem({{ $cartitem['id'] }})"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
            required />
        </div>
      </div>
    </div>
  </td>
  <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E]">
    {{ $cartitem['sku'] }}
  </td>
  <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
    ${{ $cartitem['msrp']?number_format($cartitem['msrp'], 3, '.', ','):0 }}
  </td>
  <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
    ${{ $cartitem['price']?number_format($cartitem['price'], 3, '.', ','):0 }}
  </td>
  <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
    ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 3, '.', ','):0 }}
  </td>
  <td class="px-4 py-4">
    <form class="max-w-xs mx-auto">
      <div
        class="relative flex items-center max-w-[8rem] border border-solid border-[#C5C5C5] rounded-full">
        <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="border-e border-gray-300 rounded-s-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none" onclick="updateProduct('decrement',{{ $cartitem['id'] }})">
          <x-icons.minus />

        </button>
        <input type="text" id="quantity_input_{{ $cartitem['id'] }}" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-7 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 "
          placeholder="1" required value="{{ $cartitem['quantity'] }}" onchange="updateQuantity('updateQuantity',{{ $cartitem['id'] }})" data-old-quantity="{{ $cartitem['quantity'] }}" />
        <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="border-s border-gray-300 rounded-e-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none" onclick="updateProduct('increment',{{ $cartitem['id'] }})">
          <x-icons.plus />

        </button>
      </div>
    </form>
  </td>
  <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
    ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 3, '.', ','):0 }}
  </td>
  <td class="px-4 py-4 text-sm leading-[18px] text-[#000] uppercase">
    EA
  </td>
  <td class="px-4 py-4 text-base font-bold leading-[18px] text-[#000] uppercase" id="item_total_{{ $cartitem['id'] }}">
    ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 3, '.', ','):0 }}
  </td>
  <td class="px-4 py-4">
    <div class="bg-[#E8E7E7] w-[35px] h-[35px] rounded-full flex items-center justify-center"><button onclick="updateProduct('delete',{{ $cartitem['id'] }})">
        <x-icons.delete />
      </button>
    </div>
  </td>
</tr>
<?php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; ?>
@endforeach


<tr class="odd:bg-white even:bg-gray-50 border-b">
  <td class="w-4 p-4" colspan="10">
    <div class="text-right">
      <h3 class="text-2xl	font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span> ${{ number_format($subtotal, 3, '.', ',') }}</h3>
    </div>
  </td>
</tr>
<tr
  class="odd:bg-white even:bg-gray-50 border-b">
  {{-- <td class="w-4 p-4" colspan="5">
                  <div class="flex items-center gap-2">
                    <button type="button"  onclick="clearCart({{ $cart[0]['id'] }})" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]"><x-icons.delete /> Clear Cart</button>
  </div>
  </td> --}}
  <td class="w-4 p-4" colspan="6">
    <div class="flex items-center justify-end gap-2">
      <button data-modal-target="default-modal" data-modal-toggle="default-modal" type="button"
        class="py-1.5 px-4 text-sm font-normal text-[#000] focus:outline-none bg-white rounded-full border border-[#000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
        <x-icons.map />
        Change Address
      </button>
      {{-- <a href="{{ route('shipping') }}"class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]"> Save a Quote</a> --}}
      <a class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]" href="{{ route('quote.update', $quote->id ) }}"> Update Quote</a>
    </div>
  </td>
</tr>

@endif