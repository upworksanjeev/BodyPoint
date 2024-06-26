   <div class="card-body p-0 md:p-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-2xl">
			<table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="bg-[#00838f] font-semibold text-sm text-white">
                  <tr class="whitespace-nowrap">
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Product Name  
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Stock Code
                    </th>
					<th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Mark For
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      MSRP
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Primary Discount
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      After Secondary Discount
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Qty.
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                       	Net Price 
                    </th>
                   
                    <th scope="col" class="px-4 py-3 font-bold">
                      Total
                    </th>
                  </tr>
                </thead>
                <tbody>
				<?php $subtotal=0; $tax=0.00; ?>
					@if(isset($cart[0]))
					  @foreach ($cart[0]['CartItem'] as $cartitem)
                  <tr class="odd:bg-white even:bg-gray-50 border-b">
                    <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] whitespace-nowrap border-e">
                      {{ $cartitem['Product']['name'] }}
                    </td>
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      {{ $cartitem['sku'] }}
                    </td>
					<td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      {{ $cartitem['marked_for'] }}
                    </td>

                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      ${{ $cartitem['msrp']?number_format($cartitem['msrp'], 2, '.', ','):0 }}
                    </td>
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      ${{ $cartitem['price']?number_format($cartitem['price'], 2, '.', ','):0 }}
                    </td> 
					<td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 2, '.', ','):0 }}

                    </td>
					 <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      {{ $cartitem['quantity'] }}
                    </td>

                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                        ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 2, '.', ','):0 }}

                    </td>                  
                   
                   
                    <td class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
                      ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 2, '.', ','):0 }}
                    </td>
                  </tr>
				   <?php $subtotal+=$cartitem['discount_price']*$cartitem['quantity']; ?>
              @endforeach
			  @endif
                </tbody>
              </table>
  </div>
          </div>
          <div class="card-body p-6">
            <div class="grid grid-cols-12 gap-3">
              <div class="col-span-5 sm:col-span-7">
               
				
              </div>
              <div class="col-span-4 sm:col-span-4">
                <span class="text-sm text-[#000] font-normal leading-[17px]">
                  <!--span>Sub Total: </span><br>
                  <span>Tax: </span><br>
                  <span>Shipping: </span><br-->
                  <span class="font-bold">Total Before Freight: </span>
                </span>
              </div>
              <div class="col-span-3 sm:col-span-1">
                <span class="text-sm text-[#000] font-normal leading-[17px]">
                  <!--span class="font-bold">${{ number_format($subtotal, 2, '.', ',') }}</span><br>
                  <span>${{ $tax }}</span><br>
                  <span>TBD </span><br-->
                  <span class="font-bold"> ${{ number_format($subtotal+$tax, 2, '.', ',') }}</span>
                </span>
              </div>
            </div>
          </div>