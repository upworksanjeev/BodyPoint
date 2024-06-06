<a href="{{ route('cart') }}" class="hover:text-[#fe7300] transition duration-150 ease-in-out">
  <div class="flex items-center gap-2 pe-5 py-1">
    <div class="relative">
      <div class="w-[20px] h-[20px]">
        <!-- <x-icons.basket /> -->
        <i class="fa fa-shopping-cart text-[18px] pr-2" aria-hidden="true"></i>
      </div>
      <div class="absolute top-[-6px] right-[-6px]">
        <span id="total_cart_count" class="w-[16px] h-[16px] bg-white border border-solid border-[#008C9A] text-[10px] font-bold rounded-full text-[#000] flex items-center justify-center">{{ FunHelper::getCartCount() }}</span>
      </div>
    </div>
    <p class="text-[15px] font-light">Cart</p>
  </div>
</a>