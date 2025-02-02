<footer class="footer pt-5">
    <div class="ctm-container mx-auto">
        <div class="block lg:flex items-center pb-5">
            <div class="w-full lg:w-3/4">
                <h2 class="footer-heading-title lg:text-left text-center">More Information</h2>
                <div class="flex flex-wrap lg:block  justify-center mb-5 lg:mb-0">
                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}" classes="text-sm pr-4">
                        {{ __('Home') }}
                    </x-responsive-nave-link>

                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/company-overview/" classes="text-sm pr-4">
                        {{ __('About') }}
                    </x-responsive-nave-link>

                    <x-nav-link-custom href="{{ route('login.index') }}" classes="text-sm pr-4">
                        {{ __('Partners') }}
                    </x-responsive-nave-link>

                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/timeline" classes="text-sm pr-4">
                        {{ __('Timeline') }}
                    </x-responsive-nave-link>

                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/feedback" classes="text-sm pr-4">
                        {{ __('Feedback') }}
                    </x-responsive-nave-link>
                </div>
            </div>
            <div class="w-full lg:w-1/4">
                <div class=" flex justify-center lg:justify-end  gap-3">
                    <x-nav-link-custom target="_blank" href="https://www.facebook.com/BodypointInc" classes="flex items-center justify-center">
                        <i class="text-[#333] text-[22px] fa fa-facebook" aria-hidden="true"></i>
                    </x-responsive-nave-link>

                    <x-nav-link-custom target="_blank" href="https://www.linkedin.com/company/bodypoint-inc-" classes="flex items-center justify-center">
                        <i class="text-[#333] text-[22px] fa fa-linkedin" aria-hidden="true"></i>
                    </x-responsive-nave-link>

                    <x-nav-link-custom target="_blank" href="https://www.instagram.com/bodypoint_inc/" classes="flex items-center justify-center">
                        <i class="text-[#333] text-[22px] fa fa-instagram" aria-hidden="true"></i>
                    </x-responsive-nave-link>

                    <x-nav-link-custom target="_blank" href="https://x.com/bodypoint_inc" classes="flex items-center justify-center">
                        <i class="text-[#333] text-[22px] fa fa-twitter" aria-hidden="true"></i>
                    </x-responsive-nave-link>

                    <x-nav-link-custom target="_blank" href="https://www.youtube.com/bodypointinc" classes="flex items-center justify-center">
                        <i class="text-[#333] text-[22px] fa fa-youtube" aria-hidden="true"></i>
                    </x-responsive-nave-link>

                </div>
                <div class="flex justify-center lg:justify-end py-1">
                    <x-nav-link-custom href="#!" classes="text-base pl-3">
                        {{ __('sales@bodypoint.com') }}
                    </x-responsive-nave-link>
                </div>
                <div class="relative flex lg:justify-end justify-center">
                    <img src="{{ asset('img/small-logo.png') }}" class="" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[#00838f] py-[20px] fixed bottom-0 w-full">
        <x-copyrights>
            <x-slot name="content">
                ©Copyright {{ date('Y') }}. Bodypoint. All Rights Reserved.
            </x-slot>
        </x-copyrights>
    </div>
</footer>
