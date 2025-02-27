<footer class="footer pt-5 pb-6">
    <div class="ctm-container mx-auto">
        <div class="block lg:flex items-center ">
            <div class="w-full lg:w-3/4">
                <h2 class="footer-heading-title lg:text-left text-center text-[#333333]">More Information</h2>
                <div class="flex flex-wrap lg:block  justify-center mb-5 lg:mb-0">
                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}"
                        classes="text-sm pr-4 leading-[33px] text-[#333333] hover:text-[#fe7300]">
                        {{ __('Home') }}
                        </x-responsive-nave-link>

                        <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/company-overview/"
                            classes="text-sm pr-4 leading-[33px] text-[#333333] hover:text-[#fe7300]">
                            {{ __('About') }}
                            </x-responsive-nave-link>

                            <x-nav-link-custom href="{{ route('login.index') }}"
                                classes="text-sm pr-4 leading-[33px] text-[#333333] hover:text-[#fe7300]">
                                {{ __('Partners') }}
                                </x-responsive-nave-link>

                                <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/timeline"
                                    classes="text-sm pr-4 leading-[33px] text-[#333333] hover:text-[#fe7300]">
                                    {{ __('Timeline') }}
                                    </x-responsive-nave-link>

                                    <x-nav-link-custom href="{{ config('bodypoint.home_url') }}/feedback"
                                        classes="text-sm pr-4 leading-[33px] text-[#333333] hover:text-[#fe7300]">
                                        {{ __('Feedback') }}
                                        </x-responsive-nave-link>
                </div>
            </div>
            <div class="w-full lg:w-1/4">
                <div class=" flex justify-center lg:justify-end gap-3">
                    <x-nav-link-custom target="_blank" href="https://www.facebook.com/BodypointInc"
                        classes="group flex items-center justify-center w-[30px] h-[30px] p-[10px] text-[#00838F] border border-[#00838F] rounded-full hover:text-[#FE7300] hover:border-[#FE7300]">
                        <i class="text-[#00838F] text-[14px] group-hover:text-[#FE7300] fa fa-facebook"
                            aria-hidden="true"></i>
                    </x-nav-link-custom>

                    <x-nav-link-custom target="_blank" href="https://www.linkedin.com/company/bodypoint-inc-"
                        classes="group flex items-center justify-center w-[30px] h-[30px] p-[10px] text-[#00838F] border border-[#00838F] rounded-full hover:text-[#FE7300] hover:border-[#FE7300]">
                        <i class="text-[#00838F] text-[14px] group-hover:text-[#FE7300] fa fa-linkedin" aria-hidden="true"></i>
                        </x-responsive-nave-link>

                        <x-nav-link-custom target="_blank" href="https://www.instagram.com/bodypoint_inc/"
                            classes="group flex items-center justify-center w-[30px] h-[30px] p-[10px] text-[#00838F] border border-[#00838F] rounded-full hover:text-[#FE7300] hover:border-[#FE7300]">
                            <i class="text-[#00838F] text-[14px] group-hover:text-[#FE7300] fa fa-instagram" aria-hidden="true"></i>
                            </x-responsive-nave-link>

                            <x-nav-link-custom target="_blank" href="https://x.com/bodypoint_inc"
                                classes="group flex items-center justify-center w-[30px] h-[30px] p-[10px] text-[#00838F] border border-[#00838F] rounded-full hover:text-[#FE7300] hover:border-[#FE7300]">
                                <i class="text-[#00838F] text-[14px] group-hover:text-[#FE7300] fa fa-twitter" aria-hidden="true"></i>
                                </x-responsive-nave-link>

                                <x-nav-link-custom target="_blank" href="https://www.youtube.com/bodypointinc"
                                    classes="group flex items-center justify-center w-[30px] h-[30px] p-[10px] text-[#00838F] border border-[#00838F] rounded-full hover:text-[#FE7300] hover:border-[#FE7300]">
                                    <i class="text-[#00838F] text-[14px] group-hover:text-[#FE7300] fa fa-youtube" aria-hidden="true"></i>
                                    </x-responsive-nave-link>

                </div>
                <div class="flex justify-center lg:justify-end py-1">
                    <x-nav-link-custom href="mailto:sales@bodypoint.com" classes="text-base pl-3 leading-[33px] text-[#333333]">
                        {{ __('sales@bodypoint.com') }}
                        </x-responsive-nave-link>
                </div>
                <div class="relative flex lg:justify-end justify-center">
                    {{-- <img src="{{ asset('img/small-logo.png') }}" class="" alt=""> --}}
                    <img class="max-size-60" src="{{ asset('img/bp-lg-blue-footer.png') }}" class="" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[#00838f] py-[20px] fixed bottom-0 w-full z-10">
        <x-copyrights>
            <x-slot name="content">
                ©Copyright {{ date('Y') }}. Bodypoint. All Rights Reserved.
            </x-slot>
        </x-copyrights>
    </div>
</footer>