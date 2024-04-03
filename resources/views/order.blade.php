<x-mainpage-layout>

  <x-cart-nav />
  <section class="bg-[#F6F6F6] py-9">
    <header>
      <h2 class="text-lg text-[#008c99] font-bold text-center">
        All Orders
      </h2>

      <p class="mt-1 text-sm text-gray-600 text-center">
        List of all your orders
      </p>
    </header>
    <div class="container mx-auto mt-9">
      <div class="max-w-screen-xl mx-auto">
	    
	<form action="{{ route('order-search') }}" method="post">
        <input type="hidden" value="<?= csrf_token() ?>" name="_token">

		<div class="grid gap-6 mb-6 md:grid-cols-3">
			<div>
				<label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search By:</label>
				<input type="text" id="search_input" name="search_input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Order No/ BP Number" value="{{ $search??'' }}" />
			</div>
			<div>
				<label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">Order Date: </label>
				
			<div date-rangepicker class="flex items-center">
			  <div class="relative">
				<div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
					 <x-icons.date />
				</div>
				<input name="start_date" id="start_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start" value="{{ $start_date??'' }}">
			  </div>
			  <span class="mx-4 text-gray-500">to</span>
			  <div class="relative">
				<div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
					<x-icons.date />
				</div>
				<input name="end_date" id="end_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end" value="{{ $end_date??'' }}">
			</div>
			</div>

			</div>
			<div class="flex items-center mt-5 gap-2">
			
			<button type="submit" name="search_order" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-[160px] items-left">Search Order</button>
			<a href="{{ route('order') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-right justify-center w-[160px]">Clear Search</a>
			 <button  type="submit" name="download" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Download</button>
			</div>
			</div>
	</form>
        <div class="relative overflow-x-auto sm:rounded-2xl mt-10" id="order_list">
          <x-cart.order-list :order="$order" />
        </div>
        <div class="py-6 text-right">
          <a href="{{ route('home') }}" class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2">Continue Shopping <x-icons.next-arrow /></a>
        </div>

      </div>
    </div>
  </section>
</x-mainpage-layout>