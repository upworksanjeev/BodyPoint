<x-mainpage-layout>  
  <x-cart-nav />
  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
           <x-checkout-header page="shipping"/>

        <div class="grid grid-cols-2 gap-9">
          <div class="">
            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b ">
                <h4>Shipping Information</h4>
                <button
                  class="py-1.5 px-4 text-sm font-normal text-[#000] focus:outline-none bg-white rounded-full border border-[#000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
                 <x-icons.map />
                  Change Address
                </button>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside mb-8">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Ship To:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]"> {{ $userDetail->shipping_user_name??'' }} {{ $userDetail->shipping_last_name??'' }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->shipping_address??'' }} <br>{{ $userDetail->shipping_city??'' }} {{ $userDetail->shipping_state??'' }} {{ $userDetail->shipping_zip??'' }} {{ $userDetail->shipping_country??'' }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]"> +1 {{ $userDetail->shipping_phone??'' }}</span>
                  </li>
                </ul>
				<div class="flex items-center mb-4">
					<input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-[#00707B]-600 bg-gray-100 border-gray-300 rounded focus:ring-[#00707B]-500 focus:ring-2">
					<label for="default-checkbox" class="ms-2 text-sm font-medium text-[#00707B]">Make This My Default Address</label>
				</div>
              </div>
            </div>
            <div class="card bg-white border border-gray-200 rounded-2xl shadow mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b">
                <h4>Billing Information</h4>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Name:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->billing_user_name??'' }} {{ $userDetail->billing_last_name??'' }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->billing_address??''  }} <br>{{ $userDetail->billing_city??'' }} {{ $userDetail->billing_state??'' }} {{ $userDetail->billing_zip??''  }} {{ $userDetail->billing_country??'' }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $userDetail->billing_phone??'' }}</span>
                  </li>
                </ul>
              </div>
            </div>
			<div>
            <a onclick="addToCart()" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px] float-right" href="{{ route('payment') }}">
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
