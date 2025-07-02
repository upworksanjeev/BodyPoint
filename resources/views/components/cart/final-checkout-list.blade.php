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
                   <?php $subtotal = 0;
                    $tax = 0.0; ?>
                   @if (isset($cart[0]))
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
                           ${{ $cartitem['msrp'] ? number_format($cartitem['msrp'], 3, '.', ',') : 0 }}
                       </td>
                       <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                           ${{ $cartitem['price'] ? number_format($cartitem['price'], 3, '.', ',') : 0 }}
                       </td>
                       <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                           ${{ $cartitem['discount_price'] ? number_format($cartitem['discount_price'], 3, '.', ',') : 0 }}

                       </td>
                       <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                           {{ $cartitem['quantity'] }}
                       </td>

                       <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
                           ${{ $cartitem['discount_price'] ? number_format($cartitem['discount_price'], 3, '.', ',') : 0 }}

                       </td>


                       <td class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
                           ${{ $cartitem['discount_price'] ? number_format($cartitem['discount_price'] * $cartitem['quantity'], 3, '.', ',') : 0 }}
                       </td>
                   </tr>
                   <?php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; ?>
                   @endforeach
                   @endif
               </tbody>
           </table>
       </div>
   </div>
   <div class="flex justify-end gap-3 flex-wrap pt-3 px-6 pb-6">
       <div class="min-w-[100px] sm:min-w-[250px]">
           <span class="text-sm text-[#000] font-bold leading-[17px]">Total Before Freight:</span>
       </div>
       <div class="min-w-[80px] sm:min-w-[100px] text-right">
           <span class="font-bold">${{ number_format($subtotal + $tax, 3, '.', ',') }}</span>
       </div>
   </div>
   @if($cart[0]->purchase_order_no != '')
   <div class="po-number-div flex justify-end gap-3 flex-wrap px-6 pb-6">
       <div class="min-w-[250px]"><span class="text-sm text-[#000] font-bold leading-[17px]">Your PO Number Is:</span>
       </div>
       <div class="min-w-[100px] text-right"><span class="font-bold mr-2">{{$cart[0]->purchase_order_no}}</span> <button
               data-modal-target="po-number-modal" data-modal-toggle="po-number-modal" class="edit-customer-po-number"
               type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></div>
   </div>
   @endif