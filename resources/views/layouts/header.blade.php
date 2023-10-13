<header>
    <div class="container mx-auto px-2 xl:px-10">
        <div class=" py-2 mb-5 text-sm border-b-[1px] hidden lg:flex">
            <div class="w-3/4 h-8  flex items-center text-sm xl:text-base text-[#717171]">
                <x-welcome>
                    <x-slot name="content">
                        {{ _("Welcome to bodypoint. We provides comfort and function of children and adults who use wheelchairs and other mobility devices.") }}
                    </x-slot>
                </x-welcome>

            </div>
            <div class="w-1/4 h-8 flex justify-end text-[#717171]">

                <x-phone-icon :phoneNumber="__('800.547.5716')" />
                
                <x-login-nav />
            </div>
        </div>
    </div>
    <div class="container mx-auto px-2 xl:px-10">
    <x-main-nav />
    </div>
</header>
