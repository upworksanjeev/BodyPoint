<a href="{{ route('cart') }}">
            <div class="flex items-center gap-2">
			
              <div class="relative">
                <div class="w-[20px] h-[20px]">
                
				  <x-icons.basket />
                </div>
                <div class="absolute top-[-6px] right-[-6px]">
                  <span id="total_cart_count"  class="w-[16px] h-[16px] bg-white border border-solid border-[#008C9A] text-[10px] font-bold rounded-full text-[#000] flex items-center justify-center">{{ FunHelper::getCartCount() }}</span>
                </div>
              </div>
              <p class="text-lg font-normal">Cart</p>
			 
            </div> </a>