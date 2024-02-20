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
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                    <path
                      d="M15.9303 16.5L12.3112 12.8808M12.3112 12.8808C12.9303 12.2618 13.4213 11.5268 13.7564 10.718C14.0914 9.9091 14.2639 9.04217 14.2639 8.16667C14.2639 7.29116 14.0914 6.42424 13.7564 5.61538C13.4213 4.80652 12.9303 4.07157 12.3112 3.4525C11.6921 2.83343 10.9572 2.34235 10.1483 2.00731C9.33944 1.67227 8.47252 1.49983 7.59701 1.49983C6.72151 1.49983 5.85458 1.67227 5.04573 2.00731C4.23687 2.34235 3.50192 2.83343 2.88285 3.4525C1.63257 4.70277 0.930176 6.39851 0.930176 8.16667C0.930176 9.93482 1.63257 11.6306 2.88285 12.8808C4.13312 14.1311 5.82886 14.8335 7.59701 14.8335C9.36517 14.8335 11.0609 14.1311 12.3112 12.8808Z"
                      stroke="black" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path
                    d="M17.3547 3.59922C17.296 3.52901 17.2226 3.47254 17.1398 3.4338C17.0569 3.39506 16.9665 3.37498 16.875 3.375H4.27187L3.88984 1.27656C3.83752 0.988543 3.68577 0.728024 3.46105 0.540423C3.23632 0.352823 2.95289 0.250042 2.66016 0.25H1.25C1.08424 0.25 0.925268 0.315848 0.808058 0.433058C0.690848 0.550268 0.625 0.70924 0.625 0.875C0.625 1.04076 0.690848 1.19973 0.808058 1.31694C0.925268 1.43415 1.08424 1.5 1.25 1.5H2.65625L4.65312 12.4602C4.71195 12.7852 4.85559 13.0889 5.06953 13.3406C4.77425 13.6164 4.56113 13.9686 4.45379 14.3581C4.34646 14.7477 4.3491 15.1593 4.46143 15.5474C4.57376 15.9355 4.79138 16.2849 5.09018 16.5569C5.38897 16.8289 5.75725 17.0128 6.15418 17.0883C6.55112 17.1637 6.9612 17.1278 7.33894 16.9844C7.71669 16.841 8.04735 16.5958 8.29425 16.276C8.54115 15.9562 8.69465 15.5742 8.73773 15.1725C8.7808 14.7707 8.71177 14.3649 8.53828 14H12.0867C11.9469 14.2927 11.8745 14.6131 11.875 14.9375C11.875 15.3701 12.0033 15.7931 12.2437 16.1528C12.484 16.5125 12.8257 16.7929 13.2254 16.9585C13.6251 17.1241 14.0649 17.1674 14.4893 17.083C14.9136 16.9986 15.3034 16.7902 15.6093 16.4843C15.9152 16.1784 16.1236 15.7886 16.208 15.3643C16.2924 14.9399 16.2491 14.5001 16.0835 14.1004C15.9179 13.7007 15.6375 13.359 15.2778 13.1187C14.9181 12.8783 14.4951 12.75 14.0625 12.75H6.49766C6.35129 12.75 6.20957 12.6986 6.09721 12.6048C5.98485 12.511 5.90898 12.3807 5.88281 12.2367L5.63516 10.875H14.6977C15.1368 10.8749 15.5619 10.7208 15.899 10.4394C16.2361 10.158 16.4637 9.76719 16.5422 9.33516L17.4922 4.11172C17.5083 4.02144 17.5043 3.92872 17.4805 3.84015C17.4568 3.75158 17.4138 3.66933 17.3547 3.59922ZM14.0625 14C14.2479 14 14.4292 14.055 14.5833 14.158C14.7375 14.261 14.8577 14.4074 14.9286 14.5787C14.9996 14.75 15.0182 14.9385 14.982 15.1204C14.9458 15.3023 14.8565 15.4693 14.7254 15.6004C14.5943 15.7315 14.4273 15.8208 14.2454 15.857C14.0635 15.8932 13.875 15.8746 13.7037 15.8036C13.5324 15.7327 13.386 15.6125 13.283 15.4583C13.18 15.3042 13.125 15.1229 13.125 14.9375C13.125 14.6889 13.2238 14.4504 13.3996 14.2746C13.5754 14.0988 13.8139 14 14.0625 14ZM6.5625 14C6.74792 14 6.92918 14.055 7.08335 14.158C7.23752 14.261 7.35768 14.4074 7.42864 14.5787C7.49959 14.75 7.51816 14.9385 7.48199 15.1204C7.44581 15.3023 7.35652 15.4693 7.22541 15.6004C7.0943 15.7315 6.92725 15.8208 6.7454 15.857C6.56354 15.8932 6.37504 15.8746 6.20373 15.8036C6.03243 15.7327 5.88601 15.6125 5.783 15.4583C5.67998 15.3042 5.625 15.1229 5.625 14.9375C5.625 14.6889 5.72377 14.4504 5.89959 14.2746C6.0754 14.0988 6.31386 14 6.5625 14Z"
                    fill="white" />
                </svg>
              </div>
              Check Out
            </button>
          </div>
        </div>

        <div class="relative overflow-x-auto shadow-md rounded-2xl">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-sm font-normal text-white bg-[#2F2F2F]">
              <tr>
                <th scope="col" class="px-4 py-4 font-normal">
                  Stock Code
                </th>
                <th scope="col" class="px-4 py-4 font-normal whitespace-nowrap">
                  Product Details
                </th>
                <th scope="col" class="px-4 py-4 font-normal">
                  Default Price
                </th>
                <th scope="col" class="px-4 py-4 font-normal">
                  Qty.
                </th>
                <th scope="col" class="px-4 py-4 font-normal">
                  Default Price
                </th>
                <th scope="col" class="px-4 py-4 font-normal">
                  Price
                </th>
                <th scope="col" class="px-4 py-4 font-normal">
                  Discounted Price
                </th>
                <th scope="col" class="px-4 py-4 font-normal">
                  Unit Price
                </th>
                <th scope="col" class="px-4 py-4 font-bold whitespace-nowrap">
                  Total
                </th>
                <th scope="col" class="px-4 py-4">
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                  SH450S-30
                </td>
                <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  Stayflex™ Chest Support
                </th>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                  $85
                </td>
                <td class="px-4 py-4">
                  <form class="max-w-xs mx-auto">
                    <div
                      class="relative flex items-center max-w-[8rem] border border-solid border-[#C5C5C5] rounded-full">
                      <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                        class="border-e border-gray-300 rounded-s-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h16" />
                        </svg>
                      </button>
                      <input type="text" id="quantity-input" data-input-counter
                        aria-describedby="helper-text-explanation"
                        class="bg-gray-50 border-x-0 border-gray-300 h-7 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 "
                        placeholder="999" required />
                      <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                        class="border-s border-gray-300 rounded-e-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                        </svg>
                      </button>
                    </div>
                  </form>
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $64.1
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $64.1
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $23.99
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $23.99 EA
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $64.1
                </td>
                <td class="px-4 py-4">
                  <div class="bg-[#E8E7E7] w-[35px] h-[35px] rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                      <path
                        d="M6.07143 2.85714H9.64286C9.64286 2.38354 9.45472 1.92934 9.11983 1.59445C8.78495 1.25957 8.33074 1.07143 7.85714 1.07143C7.38354 1.07143 6.92934 1.25957 6.59445 1.59445C6.25957 1.92934 6.07143 2.38354 6.07143 2.85714ZM5 2.85714C5 2.09938 5.30102 1.37266 5.83684 0.836838C6.37266 0.30102 7.09938 0 7.85714 0C8.6149 0 9.34163 0.30102 9.87745 0.836838C10.4133 1.37266 10.7143 2.09938 10.7143 2.85714H15.1786C15.3207 2.85714 15.4569 2.91358 15.5574 3.01405C15.6578 3.11452 15.7143 3.25078 15.7143 3.39286C15.7143 3.53494 15.6578 3.6712 15.5574 3.77166C15.4569 3.87213 15.3207 3.92857 15.1786 3.92857H14.2429L13.3736 14.3593C13.3103 15.1181 12.9642 15.8254 12.4039 16.341C11.8436 16.8566 11.11 17.1428 10.3486 17.1429H5.36571C4.60428 17.1428 3.87067 16.8566 3.31036 16.341C2.75005 15.8254 2.40396 15.1181 2.34071 14.3593L1.47143 3.92857H0.535714C0.393634 3.92857 0.257373 3.87213 0.156907 3.77166C0.0564411 3.6712 0 3.53494 0 3.39286C0 3.25078 0.0564411 3.11452 0.156907 3.01405C0.257373 2.91358 0.393634 2.85714 0.535714 2.85714H5ZM3.40857 14.27C3.44942 14.761 3.6733 15.2187 4.03582 15.5524C4.39834 15.8861 4.87301 16.0713 5.36571 16.0714H10.3486C10.8413 16.0713 11.316 15.8861 11.6785 15.5524C12.041 15.2187 12.2649 14.761 12.3057 14.27L13.1686 3.92857H2.54643L3.40857 14.27ZM6.25 6.42857C6.39208 6.42857 6.52834 6.48501 6.62881 6.58548C6.72927 6.68594 6.78571 6.82221 6.78571 6.96429V13.0357C6.78571 13.1778 6.72927 13.3141 6.62881 13.4145C6.52834 13.515 6.39208 13.5714 6.25 13.5714C6.10792 13.5714 5.97166 13.515 5.87119 13.4145C5.77073 13.3141 5.71429 13.1778 5.71429 13.0357V6.96429C5.71429 6.82221 5.77073 6.68594 5.87119 6.58548C5.97166 6.48501 6.10792 6.42857 6.25 6.42857ZM10 6.96429C10 6.82221 9.94356 6.68594 9.84309 6.58548C9.74263 6.48501 9.60637 6.42857 9.46429 6.42857C9.32221 6.42857 9.18594 6.48501 9.08548 6.58548C8.98501 6.68594 8.92857 6.82221 8.92857 6.96429V13.0357C8.92857 13.1778 8.98501 13.3141 9.08548 13.4145C9.18594 13.515 9.32221 13.5714 9.46429 13.5714C9.60637 13.5714 9.74263 13.515 9.84309 13.4145C9.94356 13.3141 10 13.1778 10 13.0357V6.96429Z"
                        fill="black" />
                    </svg>
                  </div>
                </td>
              </tr>
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                  SH450S-30
                </td>
                <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  Stayflex™ Chest Support
                </th>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E]">
                  $85
                </td>
                <td class="px-4 py-4">
                  <form class="max-w-xs mx-auto">
                    <div
                      class="relative flex items-center max-w-[8rem] border border-solid border-[#C5C5C5] rounded-full">
                      <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                        class="border-e border-gray-300 rounded-s-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h16" />
                        </svg>
                      </button>
                      <input type="text" id="quantity-input" data-input-counter
                        aria-describedby="helper-text-explanation"
                        class="bg-gray-50 border-x-0 border-gray-300 h-7 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 "
                        placeholder="999" required />
                      <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                        class="border-s border-gray-300 rounded-e-lg p-2 h-7 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                        <svg class="w-2 h-2 text-gray-900 dark:text-white" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                        </svg>
                      </button>
                    </div>
                  </form>
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $64.1
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $64.1
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $23.99
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $23.99 EA
                </td>
                <td class="px-4 py-4 text-sm leading-[18px] text-[#000]">
                  $64.1
                </td>
                <td class="px-4 py-4">
                  <div class="bg-[#E8E7E7] w-[35px] h-[35px] rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                      <path
                        d="M6.07143 2.85714H9.64286C9.64286 2.38354 9.45472 1.92934 9.11983 1.59445C8.78495 1.25957 8.33074 1.07143 7.85714 1.07143C7.38354 1.07143 6.92934 1.25957 6.59445 1.59445C6.25957 1.92934 6.07143 2.38354 6.07143 2.85714ZM5 2.85714C5 2.09938 5.30102 1.37266 5.83684 0.836838C6.37266 0.30102 7.09938 0 7.85714 0C8.6149 0 9.34163 0.30102 9.87745 0.836838C10.4133 1.37266 10.7143 2.09938 10.7143 2.85714H15.1786C15.3207 2.85714 15.4569 2.91358 15.5574 3.01405C15.6578 3.11452 15.7143 3.25078 15.7143 3.39286C15.7143 3.53494 15.6578 3.6712 15.5574 3.77166C15.4569 3.87213 15.3207 3.92857 15.1786 3.92857H14.2429L13.3736 14.3593C13.3103 15.1181 12.9642 15.8254 12.4039 16.341C11.8436 16.8566 11.11 17.1428 10.3486 17.1429H5.36571C4.60428 17.1428 3.87067 16.8566 3.31036 16.341C2.75005 15.8254 2.40396 15.1181 2.34071 14.3593L1.47143 3.92857H0.535714C0.393634 3.92857 0.257373 3.87213 0.156907 3.77166C0.0564411 3.6712 0 3.53494 0 3.39286C0 3.25078 0.0564411 3.11452 0.156907 3.01405C0.257373 2.91358 0.393634 2.85714 0.535714 2.85714H5ZM3.40857 14.27C3.44942 14.761 3.6733 15.2187 4.03582 15.5524C4.39834 15.8861 4.87301 16.0713 5.36571 16.0714H10.3486C10.8413 16.0713 11.316 15.8861 11.6785 15.5524C12.041 15.2187 12.2649 14.761 12.3057 14.27L13.1686 3.92857H2.54643L3.40857 14.27ZM6.25 6.42857C6.39208 6.42857 6.52834 6.48501 6.62881 6.58548C6.72927 6.68594 6.78571 6.82221 6.78571 6.96429V13.0357C6.78571 13.1778 6.72927 13.3141 6.62881 13.4145C6.52834 13.515 6.39208 13.5714 6.25 13.5714C6.10792 13.5714 5.97166 13.515 5.87119 13.4145C5.77073 13.3141 5.71429 13.1778 5.71429 13.0357V6.96429C5.71429 6.82221 5.77073 6.68594 5.87119 6.58548C5.97166 6.48501 6.10792 6.42857 6.25 6.42857ZM10 6.96429C10 6.82221 9.94356 6.68594 9.84309 6.58548C9.74263 6.48501 9.60637 6.42857 9.46429 6.42857C9.32221 6.42857 9.18594 6.48501 9.08548 6.58548C8.98501 6.68594 8.92857 6.82221 8.92857 6.96429V13.0357C8.92857 13.1778 8.98501 13.3141 9.08548 13.4145C9.18594 13.515 9.32221 13.5714 9.46429 13.5714C9.60637 13.5714 9.74263 13.515 9.84309 13.4145C9.94356 13.3141 10 13.1778 10 13.0357V6.96429Z"
                        fill="black" />
                    </svg>
                  </div>
                </td>
              </tr>
              <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td class="w-4 p-4" colspan="2">
                  <div class="">
                    <a href="{{ url('/cart') }}"
                      class="py-2.5 px-5 text-base font-normal text-[#00707B] focus:outline-none bg-white rounded-full border border-[#008C9A] hover:bg-[#008C99] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center">
                      Go to shopping cart <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="7" height="10"
                        viewBox="0 0 7 10" fill="none">
                        <path
                          d="M0.158496 1.175L3.97516 5L0.158496 8.825L1.3335 10L6.3335 5L1.3335 -2.18557e-07L0.158496 1.175Z"
                          fill="#008C9A" />
                      </svg></a>
                  </div>
                </td>
                <td class="w-4 p-4" colspan="10">
                  <div class="text-right">
                    <h3 class="text-3xl	font-normal text-[#000]"><span class="text-xl">Subtotal:</span> $130.2</h3>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  
</x-mainpage-layout>
