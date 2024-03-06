   <div class="card-body p-0 md:p-6">
            <div class="relative overflow-x-auto">
			@if(isset($order[0]))
					  @foreach ($order as $orders)
			<table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="bg-[#008C99] font-semibold text-sm text-white">
                  <tr>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Product name  
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Stock Code
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      MSRP
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Primary Discount
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Net price <br>
                      after secondary 
                      discount
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                      Qty.
                    </th>
                    <th scope="col" class="px-4 py-3 font-bold border-e border-gray-500">
                       	Net price <br> after all known discount 
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
				<?php $subtotal=0; $tax=0.00; ?>
					  @foreach ($orders['OrderItem'] as $cartitem)
                  <tr class="odd:bg-white even:bg-gray-50 border-b">
                    <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] whitespace-nowrap border-e">
                      {{ $cartitem['Product']['name'] }}
                    </td>
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      {{ $cartitem['Product']['sku'] }}
                    </td>
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      ${{ $cartitem['Product']['msrp']?number_format($cartitem['Product']['msrp'], 2, '.', ''):0 }}
                    </td>
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      ${{ $cartitem['price']?number_format($cartitem['price'], 2, '.', ''):0 }}
                    </td> 
					<td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 2, '.', ''):0 }}
                    </td>
					 <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      {{ $cartitem['quantity'] }}
                    </td>
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                        ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 2, '.', ''):0 }}
                    </td>                  
                   
                    <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                      EA
                    </td>
                    <td class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
                      ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 2, '.', ''):0 }}
                    </td>
                  </tr>
				   <?php $subtotal+=$cartitem['discount_price']*$cartitem['quantity']; ?>
              @endforeach
			   <tr
                class="odd:bg-white even:bg-gray-50 border-b">
                <td class="w-4 p-4" colspan="2">
                  
                </td>
                <td class="w-4 p-4" colspan="8">
                  <div class="text-right">
                    <h3 class="text-2xl	font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span>  ${{ number_format($subtotal, 2, '.', ',') }}</h3>
                  </div>
                </td>
              </tr>
			  
                </tbody>
              </table>
			    @endforeach
			  @endif
  </div>
          </div>
         