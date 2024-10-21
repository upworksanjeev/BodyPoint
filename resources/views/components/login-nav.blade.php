@if (Route::has('login'))
    @auth
        <div class="">

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
			<div class="rounded-full h-[35px] w-[35px] overflow-hidden rounded-full">
			<img src="{{ FunHelper::getUserProfile()?url('storage/'.FunHelper::getUserProfile()):asset('img/profile.png') }}" class="h-[35px] w-[35px] rounded-full object-cover" alt="">
			</div>
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-2 rounded-md focus:outline-none transition ease-in-out duration-150 text-lg font-normal">

                            <div> {{ Auth::user()->name }}</div>

                            <div class="ml-1">
							<x-icons.down-arrow />

                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Edit My Account') }}
                        </x-dropdown-link>
						<x-dropdown-link>
                            {{ __('My Orders') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
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
					<x-icons.menu-equal />

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

                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-responsive-nav-link :href="route('login')">
            <button
                class="rounded-lg flex items-center text-[#fff] text-[15px] font-light hover:text-[#fe7300] transition duration-150 ease-in-out">
                <i class="fa fa-lock pr-2 text-[18px]"></i> {{ __('Partner Login') }}
            </button>
        </x-responsive-nav-link>

        <!--@if (Route::has('register'))
    <x-responsive-nav-link :href="route('register')">
                    <button class="rounded-lg px-5 py-1 flex  text-sm text-[#fff] text-[15px] hover:text-[#fe7300] transition duration-150 ease-in-out">
                        {{ __('Register') }}
                    </button>
                </x-responsive-nav-link>
    @endif -->

    @endauth
@endif
