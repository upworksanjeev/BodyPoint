@if (Route::has('login'))
    @auth
         <section class="bg-white border-b border-solid border-[#E0E0E0]">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="flex items-center justify-between">
          <div class="text-base font-medium text-center text-[#000]">
            <ul class="flex flex-wrap -mb-px">
              <li class="me-2">
                <a href="{{ url('/cart') }}"
                  class="inline-block p-4 rounded-t-lg <?php if(Request::is('cart')){ echo "text-[#000] border-b-[3px] active border-[#008C99]  dark:text-blue-500 dark:border-blue-500"; }else{ echo "border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"; } ?>" aria-current="page">Shopping Cart</a>
              </li>
              <li class="me-2">
                <a href="{{ url('/quickentry') }}"
                  class="inline-block p-4 rounded-t-lg <?php if(Request::is('quickentry')){ echo "text-[#000] border-b-[3px] active border-[#008C99]  dark:text-blue-500 dark:border-blue-500"; }else{ echo "border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"; } ?>" >Quick
                  Order Entry</a>
              </li>
              <li class="me-2">
                <a href="#"
                  class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Order
                  Lookup</a>
              </li>
              <li class="me-2">
                <a href="#"
                  class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">My
                  Account</a>
              </li>
            </ul>
          </div>
          <div class="flex-1">
            <form class="max-w-lg ms-auto">
              <div class="flex items-center gap-3">
                <label for="search-dropdown" class="text-sm font-medium text-[#000]">Change Associate
                  customer</label>
                <div class="relative w-full flex flex-1">
                  <input type="search" id="search-dropdown"
                    class="block p-2.5 w-full z-20 text-sm text-[#070707] bg-white rounded-s-lg border border border-[#000] focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#070707] border-e-0"
                    placeholder="10245566 - Numotion" required />
                  <button type="submit"
                    class="p-2.5 text-sm font-medium text-[#070707] border-s-0 border border border-[#000]">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                  </button>
                  <button id="dropdown-button" data-dropdown-toggle="dropdown"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 pe-4 text-sm font-medium text-center text-white bg-[#494949] rounded-e-lg"
                    type="button"><svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                    </svg></button>
                  <div id="dropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
    @endauth
@endif
