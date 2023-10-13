<nav class="">
            <div class="mx-auto">
                <div class="relative flex flex-wrap items-center justify-between">
                    <div
                        class=" inset-y-0 left-0 flex items-center xl:hidden justify-end lg:justify-start w-6/12 lg:w-1/12 xl:w-1/12">
                        <!-- Mobile menu button-->
                        <button type="button"
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
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
                    <div class="flex items-center pr-2 sm:static sm:inset-auto sm:pr-0 w-full lg:w-5/12 xl:w-2/12">
                        <x-header-search class='w-full' />
                    </div>
                </div>
            </div>
            <div class="xl:hidden" id="mobile-menu">
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
                </div>
            </div>
        </nav>