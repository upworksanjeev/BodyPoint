 <div class="">
            <div class="card bg-white border border-gray-200 rounded-2xl shadow relative overflow-hidden">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b">
                <h4><a href="{{ route('cart') }}" class="text-[#00707B]">Edit your order</a></h4>
                <!--p><a href="{{ route('cart') }}" class="text-sm font-normal leading-[18px] text-[#00707B]">Edit your order</a></p-->
              </div>
			  <div class="card-body">
                <div class="relative overflow-x-auto">
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <tbody>
			<?php $subtotal=0; ?>
			@if(isset($cart[0]))
			  @foreach ($cart[0]['CartItem'] as $cartitem)
                      <tr
                        class="odd:bg-white even:bg-gray-50 border-b">
                        <td class="px-6 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                          <div class="flex items-center gap-2">
                            <div class="">
                              <img src="<?php if(isset($cartitem['Product']['Media'][0]['id'])){ echo url('storage/' . $cartitem['Product']['Media'][0]['id'] . '/' .$cartitem['Product']['Media'][0]['file_name']); }else{ echo "/img/standard-img.png"; } ?>" alt="product-img" class="w-[48px] h-[48px] object-cover" />
                            </div>
                            <div class="flex-1">
                              <p class="text-sm font-normal leading-[18px] mb-2"><a href="{{ route('product',$cartitem['Product']['slug']??$cartitem['Product']['name']) }}" target="_blank">{{ $cartitem['Product']['name'] }}</a></p>
                              <span class="bg-[#E4E4E4] text-gray-800 text-[11px] leading-[18px] font-medium me-2 px-2.5 py-0.5 rounded-full">Qty:{{ $cartitem['quantity'] }}</span>
                            </div>
                          </div>
                        </td>                       
                        <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] text-right">

						 ${{ $cartitem['discount_price']?number_format($cartitem['discount_price']*$cartitem['quantity'], 2, '.', ''):0 }}
                        </td>
                      </tr>
					  <?php $subtotal+=$cartitem['discount_price']*$cartitem['quantity']; ?>
			  @endforeach
			  @endif
			   <tr class="odd:bg-white even:bg-gray-50 border-b">
                <td class="w-4 p-4" colspan="2">
                  <div class="text-right">
                    <h3 class="text-2xl	font-normal text-[#000]" id="subtotal"><span class="font-bold">Subtotal:</span>  ${{ number_format($subtotal, 2, '.', ',') }}</h3>
                  </div>
                </td>                
              </tr>
			   </tbody>
            </table>
          </div>
         </div>
		 </div>
        </div>
			  
             
			