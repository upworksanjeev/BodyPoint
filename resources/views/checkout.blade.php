<x-mainpage-layout>

   
  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="grid grid-cols-1 lg:pb-14 pb-6">
          <div class="col-span-2">
            <ul class="flex items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base order-step">
              <li
                class="active flex-1 flex flex-col items-center gap-3 relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200">
                <div class="z-10">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    1
                  </span>
                </div>
                <p class="text-[13px] font-normal text-[#000]">Shipping Information</p>
              </li>
              <li
                class="flex-1 flex flex-col items-center gap-3 relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200">
                <div class="z-10">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    2
                  </span>
                </div>
                <p class="text-[13px] font-normal text-[#000]">Payment Method</p>
              </li>
              <li
                class="flex-1 flex flex-col items-center gap-3 relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200">
                <div class="z-10">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    3
                  </span>
                </div>
                <p class="text-[13px] font-normal text-[#717171]">Confirm Order</p>
              </li>
              <li class="flex-1 flex flex-col items-center gap-3">
                <div class="z-10">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    4
                  </span>
                </div>
                <p class="text-[13px] font-normal text-[#717171]">Completion</p>
              </li>
            </ul>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-9">
          <div class="">
            <div
              class="card bg-white border border-gray-200 rounded-2xl shadow dark:bg-gray-800 dark:border-gray-700 mb-4">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b ">
                <h4>Shipping Information</h4>
                <button
                  class="py-1.5 px-4 text-sm font-normal text-[#000] focus:outline-none bg-white rounded-full border border-[#000] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18" fill="none">
                    <path
                      d="M9.375 7.5C9.375 7.00272 9.17746 6.5258 8.82583 6.17417C8.47419 5.82254 7.99728 5.625 7.5 5.625C7.00272 5.625 6.52581 5.82254 6.17417 6.17417C5.82254 6.5258 5.625 7.00272 5.625 7.5C5.625 7.99728 5.82254 8.47419 6.17417 8.82582C6.52581 9.17745 7.00272 9.375 7.5 9.375C7.99728 9.375 8.47419 9.17745 8.82583 8.82582C9.17746 8.47419 9.375 7.99728 9.375 7.5ZM15 7.5C15 11.0925 11.1288 15.02 8.94875 16.9475C8.55014 17.3035 8.03442 17.5002 7.5 17.5002C6.96558 17.5002 6.44986 17.3035 6.05125 16.9475C3.87125 15.02 0 11.0925 0 7.5C-1.46764e-08 6.51509 0.193993 5.53982 0.570903 4.62987C0.947814 3.71993 1.50026 2.89314 2.1967 2.1967C2.89314 1.50026 3.71993 0.947814 4.62987 0.570904C5.53982 0.193993 6.51509 0 7.5 0C8.48491 0 9.46018 0.193993 10.3701 0.570904C11.2801 0.947814 12.1069 1.50026 12.8033 2.1967C13.4997 2.89314 14.0522 3.71993 14.4291 4.62987C14.806 5.53982 15 6.51509 15 7.5ZM13.75 7.5C13.75 5.8424 13.0915 4.25268 11.9194 3.08058C10.7473 1.90848 9.1576 1.25 7.5 1.25C5.8424 1.25 4.25269 1.90848 3.08058 3.08058C1.90848 4.25268 1.25 5.8424 1.25 7.5C1.25 8.885 2.01875 10.4937 3.2125 12.1037C4.38 13.6762 5.82125 15.075 6.87875 16.0112C7.0489 16.1655 7.27034 16.2509 7.5 16.2509C7.72966 16.2509 7.9511 16.1655 8.12125 16.0112C9.17875 15.075 10.6213 13.6775 11.7875 12.1037C12.9813 10.4937 13.75 8.885 13.75 7.5Z"
                      fill="black" />
                  </svg>
                  Change Address
                </button>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside dark:text-gray-400">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Ship To:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Test Customer</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Suite 400, 558 Occidential St Seattle,
                      Seattle, WA 98104
                      USA</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 800 444 4444</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card bg-white border border-gray-200 rounded-2xl shadow dark:bg-gray-800 dark:border-gray-700">
              <div class="card-header px-6 py-4 flex items-center justify-between border-b">
                <h4>Billing Information</h4>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside dark:text-gray-400">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Ship To:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Test Customer</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Suite 400, 558 Occidential St Seattle,
                      Seattle, WA 98104
                      USA</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px]">Phone:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 800 444 4444</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
         <x-cart.checkout-list :cart="$cart" />
        </div>
      </div>
    </div>
  </section>

  
</x-mainpage-layout>
