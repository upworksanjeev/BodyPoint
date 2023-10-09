<header>
    <div class="container mx-auto px-2 xl:px-10">
        <div class=" py-2 mb-5 text-sm border-b-[1px] hidden lg:flex">
            <div class="w-3/4 h-8  flex items-center text-sm xl:text-base text-[#717171]">
                <svg class="mr-2"
                 width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.5249 1.7207C16.3706 3.30273 16.4585 6.11523 14.8179 7.81445L9.13428 13.6738C8.78271 14.0547 8.16748 14.0547 7.81592 13.6738L2.13232 7.81445C0.491699 6.11523 0.57959 3.30273 2.42529 1.7207C4.03662 0.34375 6.43896 0.607422 7.90381 2.13086L8.48975 2.7168L9.04639 2.13086C10.5405 0.607422 12.9136 0.34375 14.5249 1.7207Z" fill="#E4573D"/>
                </svg> Welcome to bodypoint. We provides comfort and function of children and adults who use wheelchairs and other mobility devices.
            </div>
            <div class="w-1/4 h-8 flex justify-end text-[#717171]">
                <button class="px-5 py-2 flex items-center text-white font-semibold bg-[#008c99] rounded-3xl text-sm">
                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                        <path d="M14.6465 0.673828C14.959 0.732422 15.2129 0.883789 15.4082 1.12793C15.6035 1.37207 15.7012 1.66016 15.7012 1.99219C15.7012 3.75 15.3545 5.43457 14.6611 7.0459C13.9678 8.65723 13.04 10.0439 11.8779 11.2061C10.7158 12.3682 9.33397 13.291 7.73241 13.9746C6.13085 14.6582 4.4414 15 2.66405 15C2.35155 15 2.07323 14.9023 1.82909 14.707C1.58495 14.5117 1.43358 14.2578 1.37499 13.9453L0.730458 11.1914C0.652333 10.8789 0.686513 10.5762 0.832997 10.2832C0.979482 9.99023 1.20897 9.78516 1.52147 9.66797L4.48046 8.37891C4.7539 8.26172 5.0371 8.24219 5.33007 8.32031C5.62304 8.39844 5.86718 8.55469 6.06249 8.78906L6.99999 9.96094C8.58202 9.10156 9.80272 7.88086 10.6621 6.29883L9.49022 5.36133C9.25585 5.16602 9.10448 4.92188 9.03612 4.62891C8.96776 4.33594 8.98241 4.05273 9.08007 3.7793L10.3691 0.820312C10.5058 0.507812 10.7158 0.27832 10.999 0.131836C11.2822 -0.0146484 11.5801 -0.0488281 11.8926 0.0292969L14.6465 0.673828ZM2.72265 13.5938C4.81249 13.5938 6.74608 13.0762 8.52343 12.041C10.3008 11.0059 11.707 9.59961 12.7422 7.82227C13.7773 6.04492 14.2949 4.11133 14.2949 2.02148L11.6289 1.40625L10.3984 4.30664L12.3906 5.91797C11.7266 7.36328 10.96 8.51562 10.0908 9.375C9.22167 10.2344 8.06444 11.0059 6.61913 11.6895L5.0078 9.69727L2.10741 10.9277L2.72265 13.5938Z" fill="white"/>
                    </svg> 800.547.5716
                </button>
                @if(Route::has('login'))
                    @auth
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">



                                    <!-- Settings Dropdown -->
                                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    <div>{{ Auth::user()->name }}</div>

                                                    <div class="ml-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('profile.edit')">
                                                    {{ __('Profile') }}
                                                </x-dropdown-link>

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf

                                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                        {{ __('Log Out') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>

                                    <!-- Hamburger -->
                                    <div class="-mr-2 flex items-center sm:hidden">
                                        <button @click="open = ! open"
                                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16" />
                                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                        
                

                                    <!-- Responsive Navigation Menu -->
                                    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                                        <div class="pt-2 pb-3 space-y-1">
                                            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                                {{ __('Dashboard') }}
                                            </x-responsive-nav-link>
                                        </div>

                                        <!-- Responsive Settings Options -->
                                        <div class="pt-4 pb-1 border-t border-gray-200">
                                            <div class="px-4">
                                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                            </div>

                                            <div class="mt-3 space-y-1">
                                                <x-responsive-nav-link :href="route('profile.edit')">
                                                    {{ __('Profile') }}
                                                </x-responsive-nav-link>

                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf

                                                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                                        {{ __('Log Out') }}
                                                    </x-responsive-nav-link>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                 @else
                 <a href="{{ route('login') }}">
                <button class="rounded-lg px-5 py-2 flex items-center text-sm">
                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
                        <path d="M12.9697 6.5C13.3864 6.5 13.7406 6.64583 14.0322 6.9375C14.3239 7.22917 14.4697 7.58333 14.4697 8V15C14.4697 15.4167 14.3239 15.7708 14.0322 16.0625C13.7406 16.3542 13.3864 16.5 12.9697 16.5H1.96973C1.55306 16.5 1.19889 16.3542 0.907227 16.0625C0.61556 15.7708 0.469727 15.4167 0.469727 15V8C0.469727 7.58333 0.61556 7.22917 0.907227 6.9375C1.19889 6.64583 1.55306 6.5 1.96973 6.5H2.96973V5C2.96973 3.75 3.41243 2.6875 4.29785 1.8125C5.18327 0.9375 6.24577 0.5 7.48535 0.5C8.72493 0.5 9.78223 0.947917 10.6572 1.84375C11.5322 2.73958 11.9697 3.80208 11.9697 5.03125V6.5H12.9697ZM4.46973 5V6.5H10.4697V5C10.4697 4.16667 10.1781 3.45833 9.59473 2.875C9.01139 2.29167 8.30306 2 7.46973 2C6.63639 2 5.92806 2.29167 5.34473 2.875C4.76139 3.45833 4.46973 4.16667 4.46973 5ZM12.9697 15V8H1.96973V15H12.9697Z" fill="#9B9B9B"/>
                    </svg> Sign In
                </button>
                </a>

                @if(Route::has('register'))
                <a href="{{ route('register') }}"
                    class="">
                    <button class="rounded-lg px-5 py-2 flex items-center text-sm">
                        Register
                    </button>
                </a>
             @endif
            @endauth
            @endif
            </div>
        </div>
    </div>
    <div class="container mx-auto px-2 xl:px-10">
        <nav class="">
          <div class="mx-auto">
            <div class="relative flex flex-wrap items-center justify-between">
              <div class=" inset-y-0 left-0 flex items-center xl:hidden justify-end lg:justify-start w-6/12 lg:w-1/12 xl:w-1/12">
                <!-- Mobile menu button-->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                  <span class="absolute -inset-0.5"></span>
                  <span class="sr-only">Open main menu</span>
                  <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                  </svg>
                  <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div class="flex flex-1 items-center justify-start order-first lg:order-none lg:justify-between shift-logo w-6/12 lg:w-6/12 xl:w-9/12">
                <div class="flex flex-shrink-0 items-center">
                <x-application-logo class="block h-12 w-auto fill-current  text-gray-500" />
                </div>
                <div class="hidden sm:ml-6 xl:block">
                  <div class="flex space-x-4 nav-links mr-10">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="#" class="text-gray-500 px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]" aria-current="page">Product</a>
                    <a href="#" class="text-gray-500 px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">Wheelchair Positioning </a>
                    <a href="#" class="text-gray-500 px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">How to  Buy</a>
                    <a href="#" class="text-gray-500 px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">Resources</a>
                    <a href="#" class="text-gray-500 px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">About Us </a>
                    <a href="#" class="text-gray-500 px-2 py-2 font-normal text-[20px] text-md-[16px] whitespace-nowrap text-[#9B9B9B]">Partners</a>
                  </div>
                </div>
              </div>
              <div class="flex items-center pr-2 sm:static sm:inset-auto sm:pr-0 w-full lg:w-5/12 xl:w-2/12">
                <div class='w-full'>
                    <div class="relative flex items-center w-full h-10 pl-5 pr-2 overflow-hidden ctm-search bg-[#f8f8f8] rounded-3xl">
                        <input
                        class="peer h-full w-full outline-none text-sm text-gray-700 pr-2 bg-[#f8f8f8]"
                        type="text"
                        id="search"
                        placeholder="Search" /> 
                        <div class="grid place-items-center h-full w-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke-color="#616060" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="xl:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
              <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Product</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Wheelchair Positioning </a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">How to  Buy</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Resources</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">About Us</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Partners</a>
            </div>
          </div>
        </nav>
    </div>
</header>