<x-mainpage-layout>

   
  <x-cart-nav />

    <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="pb-6">
          <p class="text-[20px] font-normal leading-[24px] mb-4">Bodypoint Quick Order Instructions</p>
          <ol class="text-sm font-normal text-[#000] leading-[29px]">
            <li>1. Type part number to see a list from which to choose, and click on your desired item.</li>
            <li>2. Enter quantity.</li>
            <li>3. Click the “Add to Cart” Button.</li>
            <li>4. Repeat steps 1-3 until you have entered all your desired items, and can see the accompanying prices.
            </li>
            <li>5. Click “Go to Shopping Cart”, and follow the checkout / quote process.</li>
          </ol>
        </div>
        <div class="flex items-center lg:flex-row flex-col gap-4 justify-start mb-6">
          <div class="lg:w-[35%] w-full">
            <form class="">
              <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
				 <x-icons.search />
                 
                </div>
                <input type="search" id="default-search"
                  class="block w-full p-3 pe-0 ps-10 text-sm text-[#000] border border-[#000] rounded-full bg-white focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#000]"
                  placeholder="Enter Stock Code" required />
                <button type="submit"
                  class="text-white absolute end-2.5 top-0 bottom-0 right-0 bg-[#2F2F2F] hover:bg-[#000] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-e-full text-sm px-5 py-3">Clear</button>
              </div>
            </form>
          </div>
          <div class="flex items-center gap-3">
            <label class="text-sm font-normal text-[#000] leading-[18px]">Qty</label>
            <input type="text"
              class="block w-full p-3 text-sm text-[#000] border border-[#000] rounded-full bg-white min-w-[72px] max-w-[72px] text-center"
              placeholder="01" />
          </div>
          <div>
            <button type="button"
              class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#008C99] rounded-full border border-[#027480] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
              <div class="w-[20px] h-[20px]">
              <x-icons.basket />
              </div>
              Check Out
            </button>
          </div>
        </div>

        <div class="relative overflow-x-auto shadow-md rounded-2xl">
          
		  <x-cart-product-list page="quick-entry" :cart="$cart" />
        </div>
      </div>
    </div>
  </section>

  
</x-mainpage-layout>
