<footer class="footer">

    <div class="container mx-auto px-2 py-5 xl:px-10">
        <div class="block lg:flex items-center ">
            <div class="w-full lg:w-3/4">
                <h2 class="footer-heading-title lg:text-left text-center">More Information</h2>
                <div class="flex flex-wrap lg:block  justify-center mb-5 lg:mb-0">
                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}" classes="text-base pr-4">
                        {{ __('Home') }}
                        </x-responsive-nave-link>

                        <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/why-positioning-matters/"
                            classes="text-base pr-4">
                            {{ __('Wheelchair positioning') }}
                            </x-responsive-nave-link>
                            <x-nav-link-custom href="{{ config('bodypoint.home_url') }}company-overview/"
                                classes="text-base pr-4">
                                {{ __('About Us') }}
                                </x-responsive-nave-link>
                </div>
            </div>
            <div class="w-full lg:w-1/4">
                <div class=" flex justify-center lg:justify-end  gap-2">

                    <x-nav-link-custom href="#!"
                        classes="bg-black flex items-center justify-center w-5 h-5 rounded-full">
                        <i class="text-white text-xs fa fa-facebook" aria-hidden="true"></i>
                        </x-responsive-nave-link>
                        <x-nav-link-custom href="#!"
                            classes="bg-black flex items-center justify-center w-5 h-5 rounded-full">
                            <i class="text-white text-xs fa fa-linkedin" aria-hidden="true"></i>
                            </x-responsive-nave-link>

                            <x-nav-link-custom href="#!"
                                classes="bg-black flex items-center justify-center w-5 h-5 rounded-full">
                                <i class="text-white text-xs fa fa-instagram" aria-hidden="true"></i>
                                </x-responsive-nave-link>

                                <x-nav-link-custom href="#!"
                                    classes="bg-black flex items-center justify-center w-5 h-5 rounded-full">
                                    <i class="text-white text-xs fa fa-twitter" aria-hidden="true"></i>
                                    </x-responsive-nave-link>

                                    <x-nav-link-custom href="#!"
                                        classes="bg-black flex items-center justify-center w-5 h-5 rounded-full">
                                        <i class="text-white text-xs fa fa-pinterest" aria-hidden="true"></i>
                                        </x-responsive-nave-link>

                </div>
                <div class="flex justify-center lg:justify-end py-1">
                    <x-nav-link-custom href="#!" classes="text-base pl-3">
                        {{ __('sales@bodypoint.com') }}
                        </x-responsive-nave-link>
                </div>
                <div class="relative flex justify-center mt-3">
                    <img src="{{ asset('img/small-logo.png') }}" class="" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[#008c99] py-3">
        <x-copyrights>
            <x-slot name="content">
                © Copyrights {{ date('Y') }}. Bodypoint. All Rights Reserved.
            </x-slot>
        </x-copyrights>
    </div>
</footer>
