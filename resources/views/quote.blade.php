<x-mainpage-layout>
  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
           <x-checkout-header page="checkout"/>

        <div class="pb-6">
          <p class="text-[13px] font-normal leading-[19px] text-center">Your order summary is provided below. Please review carefully and click confirm order to process your order. Click cancel to return to your shopping cart.</p>
        </div>

        <div class="card w-full max-w-[920px] m-auto bg-white border border-gray-200 rounded-2xl shadow mb-4">
		<div id="quote_print_div">
          <div class="card-header px-6 py-2 bg-[#00838f] rounded-t-xl">
            <h4 class="text-[#fff]">Quote Details:</h4>
          </div>
          <div class="card-body p-6">
            <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
              <li class="flex items-start gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Quote No.:</span>
                <span class="text-sm text-[#000] font-normal leading-[17px]">1</span>
              </li>
              <li class="flex items-center gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Your Purchase Order No.:</span>
                <span class="py-[2px] px-5 text-sm text-white focus:outline-none bg-[#31BA32] rounded-full border border-[#31BA32] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center font-bold">Quote</span>
              </li>
            </ul>
          </div>

		    <x-shipping-info :userDetail="$user_detail" :cart="$cart" :user="$user"/>
		    <x-cart.final-checkout-list :cart="$cart"/>

           </div>
           <form action="{{ route('generateQuote') }}" method="post">
          <div class="card-body p-6 border-t">
			<h3 class="mb-4 font-semibold text-gray-900">Select a PDF Quote Option to Save</h3>
			<ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex">
				<li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
					<div class="flex items-center ps-3">
						<input id="all_price" type="radio" value="all_price" name="price_option" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" selected>
						<label for="all_price" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">All Price</label>
					</div>
				</li>
				<li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
					<div class="flex items-center ps-3">
						<input id="msrp_primary" type="radio" value="msrp_primary" name="price_option" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
						<label for="msrp_primary" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">MSRP and Primary</label>
					</div>
				</li>
				<li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r">
					<div class="flex items-center ps-3">
						<input id="msrp_only" type="radio" value="msrp_only" name="price_option" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
						<label for="msrp_only" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">MSRP Only</label>
					</div>
				</li>
			</ul>
		  </div>
          <div class="card-body p-6 border-t">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>
			   <input type="hidden" value="<?= csrf_token() ?>" name="_token">
			  <button  type="submit" onclick="makeButtonDisable(this)" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Generate Quote</button>
			  </form>




            </div>
          </div>
		   </form>
        </div>
      </div>
    </div>
  </section>
@push('other-scripts')
<script>

function print_window(){
   window.print();
}

</script>
@endpush

</x-mainpage-layout>

