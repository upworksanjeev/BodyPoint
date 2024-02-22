<x-mainpage-layout>

   
  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="pb-6">
          <p class="text-[13px] font-normal leading-[19px]">Welcome to your shopping cart! Use this area to review the
            products that you have selected to purchase. From here you can add or subtract quantities of merchandise,
            delete a selection, recalculate your order and proceed to checkout</p>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-2xl">
		<x-cart-product-list page="cart" :cart="$cart" />
         
        </div>
        <div class="py-6 text-right">
          <a href="" class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2 block">Continue Shopping <x-icons.next-arrow /></a>
        </div>
        <div class="bg-white p-6 rounded-[10px]">
          <p class="text-[13px] font-[300] text-[#1A1A1A] leading-[23px]"><span class="text-[#004A52]">Note:</span> By selecting "Save A Quote", you will be prompted to select the shipping address, select a shipping method, confirm payment method, and confirm your quote. <br class="lg:block hidden"/>

            Please note, this will be saved in our system as a quote.</p>
        </div>
      </div>
    </div>
  </section>


  
</x-mainpage-layout>
