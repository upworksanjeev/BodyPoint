<x-mainpage-layout>

   
  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
       <x-checkout-header page="payment"/>

        <div class="grid grid-cols-2 gap-9">
          <div class="">
            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow dark:bg-gray-800 dark:border-gray-700 mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b ">
                <h4>Choose Payment</h4>
                
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside dark:text-gray-400">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Payment Method:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Invoice-30</span>
                  </li>
                 
                </ul>
              </div>
            </div>
           
			<div>
            <a onclick="addToCart()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 justify-center w-[160px] float-right" href="{{ route('checkout') }}">
              Next
            </a>
          </div>
          </div>
         <x-cart.checkout-list :cart="$cart" />
        </div>
      </div>
    </div>
  </section>

  
</x-mainpage-layout>
