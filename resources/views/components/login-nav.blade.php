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
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
        <x-responsive-nav-link :href="route('login')">
            <button class="rounded-lg px-5 py-2 flex items-center text-sm">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17"
                    fill="none">
                    <path
                        d="M12.9697 6.5C13.3864 6.5 13.7406 6.64583 14.0322 6.9375C14.3239 7.22917 14.4697 7.58333 14.4697 8V15C14.4697 15.4167 14.3239 15.7708 14.0322 16.0625C13.7406 16.3542 13.3864 16.5 12.9697 16.5H1.96973C1.55306 16.5 1.19889 16.3542 0.907227 16.0625C0.61556 15.7708 0.469727 15.4167 0.469727 15V8C0.469727 7.58333 0.61556 7.22917 0.907227 6.9375C1.19889 6.64583 1.55306 6.5 1.96973 6.5H2.96973V5C2.96973 3.75 3.41243 2.6875 4.29785 1.8125C5.18327 0.9375 6.24577 0.5 7.48535 0.5C8.72493 0.5 9.78223 0.947917 10.6572 1.84375C11.5322 2.73958 11.9697 3.80208 11.9697 5.03125V6.5H12.9697ZM4.46973 5V6.5H10.4697V5C10.4697 4.16667 10.1781 3.45833 9.59473 2.875C9.01139 2.29167 8.30306 2 7.46973 2C6.63639 2 5.92806 2.29167 5.34473 2.875C4.76139 3.45833 4.46973 4.16667 4.46973 5ZM12.9697 15V8H1.96973V15H12.9697Z"
                        fill="#9B9B9B" />
                </svg> {{ __(' Sign In') }}
            </button>
        </x-responsive-nav-link>
        @if(Route::has('register'))
            <x-responsive-nav-link :href="route('register')">
                <button class="rounded-lg px-5 py-2 flex items-center text-sm">
                    {{ __('Register') }}
                </button>
            </x-responsive-nav-link>
        @endif
    @endauth
@endif
