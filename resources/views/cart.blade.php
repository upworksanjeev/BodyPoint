<x-mainpage-layout>

   
  <section class="bg-white border-b border-solid border-[#E0E0E0]">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="flex items-center justify-between">
          <div class="text-base font-medium text-center text-[#000]">
            <ul class="flex flex-wrap -mb-px">
              <li class="me-2">
                <a href="#"
                  class="inline-block p-4 text-[#000] border-b-[3px] border-[#008C99] rounded-t-lg active dark:text-blue-500 dark:border-blue-500"
                  aria-current="page">Shopping Cart</a>
              </li>
              <li class="me-2">
                <a href="#"
                  class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Quick
                  Order Entry</a>
              </li>
              <li class="me-2">
                <a href="#"
                  class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Order
                  Lookup</a>
              </li>
              <li class="me-2">
                <a href="#"
                  class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">My
                  Account</a>
              </li>
            </ul>
          </div>
          <div class="flex-1">
            <form class="max-w-lg ms-auto">
              <div class="flex items-center gap-3">
                <label for="search-dropdown" class="text-sm font-medium text-[#000]">Change Associate
                  customer</label>
                <div class="relative w-full flex flex-1">
                  <input type="search" id="search-dropdown"
                    class="block p-2.5 w-full z-20 text-sm text-[#070707] bg-white rounded-s-lg border border border-[#000] focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#070707] border-e-0"
                    placeholder="10245566 - Numotion" required />
                  <button type="submit"
                    class="p-2.5 text-sm font-medium text-[#070707] border-s-0 border border border-[#000]">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                  </button>
                  <button id="dropdown-button" data-dropdown-toggle="dropdown"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 pe-4 text-sm font-medium text-center text-white bg-[#494949] rounded-e-lg"
                    type="button"><svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                    </svg></button>
                  <div id="dropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-[#F6F6F6] py-9">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="pb-6">
          <p class="text-[13px] font-normal leading-[19px]">Welcome to your shopping cart! Use this area to review the
            products that you have selected to purchase. From here you can add or subtract quantities of merchandise,
            delete a selection, recalculate your order and proceed to checkout</p>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-2xl">
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
                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h16" />
                        </svg>
                      </button>
                      <input type="text" id="quantity-input" data-input-counter
                        aria-describedby="helper-text-explanation"
                        class="bg-gray-50 border-x-0 border-gray-300 h-7 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 "
                        placeholder="1" required value="{{ $cartitem['quantity'] }}" />
                      <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                        class="border-s border-gray-300 rounded-e-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                        </svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                      <path
                        d="M6.07143 2.85714H9.64286C9.64286 2.38354 9.45472 1.92934 9.11983 1.59445C8.78495 1.25957 8.33074 1.07143 7.85714 1.07143C7.38354 1.07143 6.92934 1.25957 6.59445 1.59445C6.25957 1.92934 6.07143 2.38354 6.07143 2.85714ZM5 2.85714C5 2.09938 5.30102 1.37266 5.83684 0.836838C6.37266 0.30102 7.09938 0 7.85714 0C8.6149 0 9.34163 0.30102 9.87745 0.836838C10.4133 1.37266 10.7143 2.09938 10.7143 2.85714H15.1786C15.3207 2.85714 15.4569 2.91358 15.5574 3.01405C15.6578 3.11452 15.7143 3.25078 15.7143 3.39286C15.7143 3.53494 15.6578 3.6712 15.5574 3.77166C15.4569 3.87213 15.3207 3.92857 15.1786 3.92857H14.2429L13.3736 14.3593C13.3103 15.1181 12.9642 15.8254 12.4039 16.341C11.8436 16.8566 11.11 17.1428 10.3486 17.1429H5.36571C4.60428 17.1428 3.87067 16.8566 3.31036 16.341C2.75005 15.8254 2.40396 15.1181 2.34071 14.3593L1.47143 3.92857H0.535714C0.393634 3.92857 0.257373 3.87213 0.156907 3.77166C0.0564411 3.6712 0 3.53494 0 3.39286C0 3.25078 0.0564411 3.11452 0.156907 3.01405C0.257373 2.91358 0.393634 2.85714 0.535714 2.85714H5ZM3.40857 14.27C3.44942 14.761 3.6733 15.2187 4.03582 15.5524C4.39834 15.8861 4.87301 16.0713 5.36571 16.0714H10.3486C10.8413 16.0713 11.316 15.8861 11.6785 15.5524C12.041 15.2187 12.2649 14.761 12.3057 14.27L13.1686 3.92857H2.54643L3.40857 14.27ZM6.25 6.42857C6.39208 6.42857 6.52834 6.48501 6.62881 6.58548C6.72927 6.68594 6.78571 6.82221 6.78571 6.96429V13.0357C6.78571 13.1778 6.72927 13.3141 6.62881 13.4145C6.52834 13.515 6.39208 13.5714 6.25 13.5714C6.10792 13.5714 5.97166 13.515 5.87119 13.4145C5.77073 13.3141 5.71429 13.1778 5.71429 13.0357V6.96429C5.71429 6.82221 5.77073 6.68594 5.87119 6.58548C5.97166 6.48501 6.10792 6.42857 6.25 6.42857ZM10 6.96429C10 6.82221 9.94356 6.68594 9.84309 6.58548C9.74263 6.48501 9.60637 6.42857 9.46429 6.42857C9.32221 6.42857 9.18594 6.48501 9.08548 6.58548C8.98501 6.68594 8.92857 6.82221 8.92857 6.96429V13.0357C8.92857 13.1778 8.98501 13.3141 9.08548 13.4145C9.18594 13.515 9.32221 13.5714 9.46429 13.5714C9.60637 13.5714 9.74263 13.515 9.84309 13.4145C9.94356 13.3141 10 13.1778 10 13.0357V6.96429Z"
                        fill="black" />
                    </svg>
                  </div>
                </td>
              </tr>
			  <?php $subtotal+=$cartitem['discount_price']; ?>
              @endforeach
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4" colspan="11">
                  <div class="text-right">
                    <h3 class="text-3xl	font-normal text-[#000]"><span class="text-xl">Subtotal:</span>  ${{ $subtotal }}</h3>
                  </div>
                </td>                
              </tr>
			  @endif
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4" colspan="5">
                  <div class="flex items-center gap-2">
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                      <path d="M6.07143 2.85714H9.64286C9.64286 2.38354 9.45472 1.92934 9.11983 1.59445C8.78495 1.25957 8.33074 1.07143 7.85714 1.07143C7.38354 1.07143 6.92934 1.25957 6.59445 1.59445C6.25957 1.92934 6.07143 2.38354 6.07143 2.85714ZM5 2.85714C5 2.09938 5.30102 1.37266 5.83684 0.836838C6.37266 0.30102 7.09938 0 7.85714 0C8.6149 0 9.34163 0.30102 9.87745 0.836838C10.4133 1.37266 10.7143 2.09938 10.7143 2.85714H15.1786C15.3207 2.85714 15.4569 2.91358 15.5574 3.01405C15.6578 3.11452 15.7143 3.25078 15.7143 3.39286C15.7143 3.53494 15.6578 3.6712 15.5574 3.77166C15.4569 3.87213 15.3207 3.92857 15.1786 3.92857H14.2429L13.3736 14.3593C13.3103 15.1181 12.9642 15.8254 12.4039 16.341C11.8436 16.8566 11.11 17.1428 10.3486 17.1429H5.36571C4.60428 17.1428 3.87067 16.8566 3.31036 16.341C2.75005 15.8254 2.40396 15.1181 2.34071 14.3593L1.47143 3.92857H0.535714C0.393634 3.92857 0.257373 3.87213 0.156907 3.77166C0.0564411 3.6712 0 3.53494 0 3.39286C0 3.25078 0.0564411 3.11452 0.156907 3.01405C0.257373 2.91358 0.393634 2.85714 0.535714 2.85714H5ZM3.40857 14.27C3.44942 14.761 3.6733 15.2187 4.03582 15.5524C4.39834 15.8861 4.87301 16.0713 5.36571 16.0714H10.3486C10.8413 16.0713 11.316 15.8861 11.6785 15.5524C12.041 15.2187 12.2649 14.761 12.3057 14.27L13.1686 3.92857H2.54643L3.40857 14.27ZM6.25 6.42857C6.39208 6.42857 6.52834 6.48501 6.62881 6.58548C6.72927 6.68594 6.78571 6.82221 6.78571 6.96429V13.0357C6.78571 13.1778 6.72927 13.3141 6.62881 13.4145C6.52834 13.515 6.39208 13.5714 6.25 13.5714C6.10792 13.5714 5.97166 13.515 5.87119 13.4145C5.77073 13.3141 5.71429 13.1778 5.71429 13.0357V6.96429C5.71429 6.82221 5.77073 6.68594 5.87119 6.58548C5.97166 6.48501 6.10792 6.42857 6.25 6.42857ZM10 6.96429C10 6.82221 9.94356 6.68594 9.84309 6.58548C9.74263 6.48501 9.60637 6.42857 9.46429 6.42857C9.32221 6.42857 9.18594 6.48501 9.08548 6.58548C8.98501 6.68594 8.92857 6.82221 8.92857 6.96429V13.0357C8.92857 13.1778 8.98501 13.3141 9.08548 13.4145C9.18594 13.515 9.32221 13.5714 9.46429 13.5714C9.60637 13.5714 9.74263 13.515 9.84309 13.4145C9.94356 13.3141 10 13.1778 10 13.0357V6.96429Z" fill="black"/>
                      </svg> Clear Cart</button>
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                      <path d="M8.33333 15.2917L7.125 14.1917C2.83333 10.3 0 7.725 0 4.58333C0 2.00833 2.01667 0 4.58333 0C6.03333 0 7.425 0.675 8.33333 1.73333C9.24167 0.675 10.6333 0 12.0833 0C14.65 0 16.6667 2.00833 16.6667 4.58333C16.6667 7.725 13.8333 10.3 9.54167 14.1917L8.33333 15.2917Z" fill="#FF1A1A"/>
                      </svg> Save Cart</button>
                  </div>
                </td>                
                <td class="w-4 p-4" colspan="6">
                  <div class="flex items-center justify-end gap-2">
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"> Save a Quote</button>
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#008C99] rounded-full border border-[#027480] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center"> Check Out</button>
                  </div>
                </td>                
              </tr>
            </tbody>
          </table>
        </div>
        <div class="py-6 text-right">
          <a href="" class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2 block">Continue Shopping <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="7" height="10" viewBox="0 0 7 10" fill="none">
            <path d="M0.158496 1.175L3.97516 5L0.158496 8.825L1.3335 10L6.3335 5L1.3335 -2.18557e-07L0.158496 1.175Z" fill="#008C9A"/>
            </svg></a>
        </div>
        <div class="bg-white p-6 rounded-[10px]">
          <p class="text-[13px] font-[300] text-[#1A1A1A] leading-[23px]"><span class="text-[#004A52]">Note:</span> By selecting "Save A Quote", you will be prompted to select the shipping address, select a shipping method, confirm payment method, and confirm your quote. <br class="lg:block hidden"/>

            Please note, this will be saved in our system as a quote.</p>
        </div>
      </div>
    </div>
  </section>


  
</x-mainpage-layout>
