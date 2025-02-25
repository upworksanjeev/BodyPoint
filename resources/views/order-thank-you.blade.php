<x-mainpage-layout>


  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="">
          <h2 class="font-bold text-[#00707B] mb-5 text-center">Thank You For Your Purchase!</h2>

          {{-- <h5 class="font-bold text-[#00707B] mb-5 text-center">Estimated Ship Date: {{ date('F j, Y',strtotime($order['created_at'])) }} </h5> --}}

		   <div class="">
   <div class="card bg-white border border-gray-200 rounded-2xl shadow relative overflow-hidden">
     <div class="card-header px-6 py-4 flex items-center justify-between border-b bg-[#00838f]">
       <h4 class="text-[#fff] text-left">Order Date: {{ date('F j, Y',strtotime($order['created_at'])) }}</h4>
       <h4 class="text-[#fff] text-center">Order Details</h4>
        <h4 class="text-[#fff] text-right">Order No: {{ $order['purchase_order_no'] }}</h4>
       <h4 class="text-[#fff] text-right">Customer PO No: {{ $order['customer_po_number'] ?? '' }}</h4>
     </div>
     <div class="card-body">
       <div class="relative overflow-x-auto">
         <table class="w-full text-sm text-left rtl:text-right text-gray-500">
           <tbody>
             <?php $subtotal = 0; ?>
             @if(isset($order))
             @foreach ($order['OrderItem'] as $cartitem)
             <tr class="odd:bg-white even:bg-gray-50 border-b">
               <td class="px-6 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                 <div class="flex items-center gap-2">
                   <div class="">
                     <img src="<?php if (isset($cartitem['Product']['Media'][0]['id'])) {
                                  echo url('storage/' . $cartitem['Product']['Media'][0]['id'] . '/' . $cartitem['Product']['Media'][0]['file_name']);
                                } else {
                                  echo "/img/standard-img.png";
                                } ?>" alt="product-img" class="w-[48px] h-[48px] object-cover" />
                   </div>
                   <div class="flex-1">
                     <p class="text-sm font-normal leading-[18px] mb-2"><a href="{{ route('product',$cartitem['Product']['slug']??$cartitem['Product']['name']) }}" target="_blank">{{ $cartitem['Product']['name'] }}</a></p>
                     <span class="bg-[#E4E4E4] text-gray-800 text-[11px] leading-[18px] font-medium me-2 px-2.5 py-0.5 rounded-full">Qty:{{ $cartitem['quantity'] }}</span>
                   </div>
                 </div>
               </td>
               <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] text-right">

                 ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 2, '.', ','):0 }}
               </td>
             </tr>
             <?php $subtotal += $cartitem['discount_price'] * $cartitem['quantity']; ?>
             @endforeach
             @endif
             <tr class="odd:bg-white even:bg-gray-50 border-b">
               <td class="min-w-[200px] p-4" colspan="2">
                 <div class="text-right">
                   <h3 class="text-2xl	font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span> ${{ number_format($subtotal, 2, '.', ',') }}</h3>
                 </div>
               </td>
             </tr>
			   <tr
                class="odd:bg-white even:bg-gray-50 border-b">
                <td class="min-w-[200px] p-4" colspan="5">
                  <div class="flex whitespace-nowrap items-center gap-2">
                    <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[260px]">Continue Shopping</a>
                  </div>
                </td>
                <td class="min-w-[200px] p-4" colspan="6">
                  <div class="flex whitespace-nowrap items-center justify-end gap-2">

					<form action="{{ route('receipt-download') }}" method="post">
					  <input type="hidden" value="<?= csrf_token() ?>" name="_token">
						  <input type="hidden" name="order_id" value="{{ $order['id'] }}">
						  <button  type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center">Download Order Confirmation</button>
					  </form>

                  </div>
                </td>
              </tr>
           </tbody>
         </table>
       </div>
     </div>
   </div>
 </div>
        </div>




      </div>
    </div>
  </section>



</x-mainpage-layout>
