  <nav x-data="{ open: false }" class="">
      <div class="mx-auto">
          <div class="relative flex flex-wrap items-center justify-between">
              <div
                  class=" inset-y-0 left-0 flex items-center xl:hidden justify-end lg:justify-start w-6/12 lg:w-1/12 xl:w-1/12">
                  <!-- Mobile menu button-->
                  <button @click="open = ! open"
                      class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                      <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                          <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                          <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              <div
                  class="flex flex-1 items-center justify-start order-first lg:order-none lg:justify-between shift-logo w-6/12 lg:w-6/12 xl:w-9/12">
                  <div class="flex flex-shrink-0 items-center">
                      <a href="/">
                          <x-application-logo class="block h-12 w-auto fill-current  text-gray-500" />
                      </a>
                  </div>
                  <div class="hidden sm:ml-6 xl:block">
                      <div class="flex space-x-4 nav-links mr-10">
                          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                          <x-nav-link-custom href="#"
                              classes="px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]"
                              aria-current="page">
                              {{ __('Product') }}
                          </x-nav-link-custom>
                          <x-nav-link-custom href="#"
                              classes="px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">
                              {{ __('Wheelchair Positioning') }}
                              </x-responsive-nave-link>
                              <x-nav-link-custom href="#"
                                  classes="px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">
                                  {{ __('How to  Buy') }}
                                  </x-responsive-nave-link>
                                  <x-nav-link-custom href="#"
                                      classes="px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">
                                      {{ __('Resources') }}
                                      </x-responsive-nave-link>
                                      <x-nav-link-custom href="#"
                                          classes="px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">
                                          {{ __('About Us') }}
                                          </x-responsive-nave-link>
                                          <x-nav-link-custom href="#"
                                              classes="px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">
                                              {{ __('Partners') }}
                                              </x-responsive-nave-link>
                      </div>
                  </div>
              </div>
              <div
                  class="flex items-center pr-2  pt-2 sm:pt-0  sm:static sm:inset-auto sm:pr-0 w-full lg:w-5/12 xl:w-2/12">
                  <x-header-search class='w-full' />
              </div>
          </div>
      </div>
      <!-- Hamburger -->


      <!-- Responsive Navigation Menu -->
      <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden">


          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
              <div class="space-y-1 px-2 pb-3 pt-2">

                  <x-nav-link-custom href="#"
                      classes="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium')"
                      aria-current="page">
                      {{ __('Product') }}
                      </x-responsive-nave-link>
                      <x-nav-link-custom href="#"
                          classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                          {{ __('Wheelchair Positioning') }}
                          </x-responsive-nave-link>
                          <x-nav-link-custom href="#"
                              classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                              {{ __('How to  Buy') }}
                              </x-responsive-nave-link>
                              <x-nav-link-custom href="#"
                                  classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                  {{ __('Resources') }}
                                  </x-responsive-nave-link>
                                  <x-nav-link-custom href="#"
                                      classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                      {{ __('About Us') }}
                                      </x-responsive-nave-link>
                                      <x-nav-link-custom href="#"
                                          classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                          {{ __('Partners') }}
                                          </x-responsive-nave-link>

                                          <x-nav-link-custom :href="route('login')"
                                              classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">
                                              {{ __(' Sign In') }}

                                              </x-responsive-nav-link>

                                              <x-nav-link-custom :href="route('register')"
                                                  classes="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">

                                                  {{ __('Register') }}

                                                  </x-responsive-nav-link>
              </div>
  </nav>