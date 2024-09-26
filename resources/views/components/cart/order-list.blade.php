
<div id="accordion-collapse" data-accordion="collapse">

 @if(isset($order[0]))
       @foreach ($order as $orders)
  <h2 id="accordion-collapse-heading-{{ $orders['id'] }}" class="">

    <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-[16px] focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 gap-3" data-accordion-target="#accordion-collapse-body-{{ $orders['id'] }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $orders['id'] }}">

      <span>Order No: {{ $orders['purchase_order_no'] }}</span>
      @if(!empty($orders['status']))
        <span>Order Status: {{ $orders['status'] }}</span>
      @endif
	  <!--x-icons.down-arrow /-->
	  <span class="text-center">Order Date: {{ date('F j, Y',strtotime($orders['created_at'])) }}</span>
    </button>
  </h2>
  <div id="accordion-collapse-body-{{ $orders['id'] }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $orders['id'] }}">
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
               Net Price
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
           <?php $subtotal = 0;
            $tax = 0.00; ?>
           @foreach ($orders['OrderItem'] as $cartitem)
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
               {{ $cartitem['quantity'] }}
             </td>

             <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
               ${{ $cartitem['discount_price']?number_format($cartitem['discount_price'], 2, '.', ','):0 }}

             </td>

             <td class="px-4 py-4 text-[13px] leading-[18px] text-[#000] border-e">
               EA
             </td>
             <td class="px-4 py-4 text-[13px] font-bold leading-[18px] text-[#000]">
               ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 2, '.', ','):0 }}
             </td>
           </tr>
           <?php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; ?>
           @endforeach
           <tr class="odd:bg-white even:bg-gray-50 border-b">
             <td class="w-4 p-4" colspan="2">
				<div class="text-left"><span>BP Number: {{ $orders['bp_number'] }}</span></div>
             </td>
             <td class="w-4 p-4" colspan="8">

               <div class="text-right">
                 <h3 class="text-2xl font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span> ${{ number_format($subtotal, 2, '.', ',') }}</h3>
               </div>
             </td>
           </tr>

         </tbody>
       </table>

    </div>
  </div>
    @endforeach
       @endif
	     </div>

