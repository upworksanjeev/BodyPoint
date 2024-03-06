<x-mainpage-layout>
   
  <x-cart-nav />
  <section class="bg-[#F6F6F6] py-9">
  <header>
        <h2 class="text-lg font-medium text-[#008c99] font-bold text-center">
            All Orders
        </h2>

        <p class="mt-1 text-sm text-gray-600 text-center">
            List of all your orders
        </p>
    </header>
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
       
		

        <div class="relative overflow-x-auto rounded-2xl">
		<x-cart.order-list :order="$order" />
         
        </div>
        <div class="py-6 text-right">
          <a href="{{ route('home') }}" class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2 block">Continue Shopping <x-icons.next-arrow /></a>
        </div>
       
      </div>
    </div>
  </section>

</x-mainpage-layout>
