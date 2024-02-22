 <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-sm font-normal text-white bg-[#2F2F2F]">
              <tr>
                <th scope="col" class="p-4 pe-0">
                  <div class="flex items-center">
                    <input id="checkbox-all-search" type="checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                  </div>
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  Product name
                </th>
                <th scope="col" class="px-4 py-3 font-normal whitespace-nowrap">
                  Stock Code
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  MSRP
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  Primary Discount
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  Net price
                  after secondy
                  discount
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  Qty.
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  Net price
                  after all known
                  discount
                </th>
                <th scope="col" class="px-4 py-3 font-normal">
                  Unit
                </th>
                <th scope="col" class="px-4 py-3 font-bold whitespace-nowrap">
                  Item Total
                </th>
                <th scope="col" class="px-4 py-3">

                </th>
              </tr>
            </thead>
            <tbody>
			<?php $subtotal=0; ?>
			@if(isset($cart[0]))
			  @foreach ($cart[0]['CartItem'] as $cartitem)
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4 pe-0">
                  <div class="flex items-center">
                    <input id="checkbox-table-search-1" type="checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                  </div>
                </td>
                <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <div class="flex items-center gap-2">
                    <div class="">
                      <img src="<?php if(isset($cartitem['Product']['Media'][0]['id'])){ echo url('storage/' . $cartitem['Product']['Media'][0]['id'] . '/' .$cartitem['Product']['Media'][0]['file_name']); }else{ echo "/img/standard-img.png"; } ?>" alt="product-img" class="w-[48px] h-[48px] object-cover" />
                    </div>
                    <div class="flex-1">
                      <p class="text-sm font-normal leading-[18px] mb-2">{{ $cartitem['Product']['name'] }}</p>
                      <div class="flex gap-2">
                        <label class="text-sm font-normal leading-4 text-[#525252]">Marked <br />
                          for:</label>
                        <input type="text"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                          required />
                      </div>
                    </div>
                  </div>
                </th>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                  {{ $cartitem['Product']['sku'] }}
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  ${{ $cartitem['Product']['msrp'] }}
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  ${{ $cartitem['price'] }}
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                 ${{ $cartitem['discount_price'] }}
                </td>
                <td class="px-4 py-4">
                  <form class="max-w-xs mx-auto">
                    <div
                      class="relative flex items-center max-w-[8rem] border border-solid border-[#C5C5C5] rounded-full">
                      <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                        class="border-e border-gray-300 rounded-s-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                       <x-icons.minus /> 
                        
                      </button>
                      <input type="text" id="quantity-input" data-input-counter
                        aria-describedby="helper-text-explanation"
                        class="bg-gray-50 border-x-0 border-gray-300 h-7 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 "
                        placeholder="1" required value="{{ $cartitem['quantity'] }}" />
                      <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                        class="border-s border-gray-300 rounded-e-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                        <x-icons.plus />
                        
                      </button>
                    </div>
                  </form>
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                ${{ $cartitem['discount_price'] }}
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000] uppercase">
                  eA
                </td>
                <td class="px-4 py-4 text-base font-bold leading-[18px] text-[#000] uppercase">
                  ${{ $cartitem['discount_price'] }}
                </td>
                <td class="px-4 py-4">
                  <div class="bg-[#E8E7E7] w-[35px] h-[35px] rounded-full flex items-center justify-center">
                  <x-icons.delete />
                  </div>
                </td>
              </tr>
			  <?php $subtotal+=$cartitem['discount_price']; ?>
              @endforeach
			  @if($page=='cart')
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4" colspan="11">
                  <div class="text-right">
                    <h3 class="text-3xl	font-normal text-[#000]"><span class="text-xl">Subtotal:</span>  ${{ $subtotal }}</h3>
                  </div>
                </td>                
              </tr>
			   <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4" colspan="5">
                  <div class="flex items-center gap-2">
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"><x-icons.delete /> Clear Cart</button>
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"> <x-icons.heart /> Save Cart</button>
                  </div>
                </td>                
                <td class="w-4 p-4" colspan="6">
                  <div class="flex items-center justify-end gap-2">
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"> Save a Quote</button>
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#008C99] rounded-full border border-[#027480] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"> Check Out</button>
                  </div>
                </td>                
              </tr>
			  @elseif($page=='quick-entry')
			   <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4" colspan="2">
                  <div class="">
                    <a href="{{ route('cart') }}"
                      class="py-2.5 px-5 text-base font-normal text-[#00707B] focus:outline-none bg-white rounded-full border border-[#008C9A] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
                      Go to shopping cart   <x-icons.next-arrow /></a>
                  </div>
                </td>
                <td class="w-4 p-4" colspan="10">
                  <div class="text-right">
                    <h3 class="text-3xl	font-normal text-[#000]"><span class="text-xl">Subtotal:</span>  ${{ $subtotal }}</h3>
                  </div>
                </td>
              </tr>
			  @endif
			  
             
			  @endif
            </tbody>
          </table>