@php
    $user = getCustomer();
@endphp
@if (Route::has('login'))
    @auth
        <section class="bg-white border-b border-solid border-[#E0E0E0] py-[25px] lg:py-0 px-3">
            <div class="container mx-auto">
                <div class="max-w-screen-xl mx-auto">
                    <div class="flex items-center justify-between lg:flex-nowrap flex-wrap pt-1 pb-2">
                        <div
                            class="text-base font-medium text-center text-[#000] overflow-y-hidden overflow-x-auto lg:whitespace-pre-wrap whitespace-nowrap lg:mb-0 mb-4 flex-auto lg:flex-1">
                            <ul class="flex -mb-px">
                                <li class="me-2">
                                    <a href="{{ route('dashboard') }}" class="inline-block p-4 rounded-t-lg <?php if (Request::is('dashboard')) {
                                        echo 'text-[#000] border-b-[3px] active border-[#00838f]';
                                    } else {
                                        echo 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300';
                                    } ?>">Home</a>
                                </li>
                                <li class="me-2">
                                    <a href="{{ route('cart') }}" class="inline-block p-4 rounded-t-lg <?php if (Request::is('cart')) {
                                        echo 'text-[#000] border-b-[3px] active border-[#00838f]';
                                    } else {
                                        echo 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300';
                                    } ?>"
                                        aria-current="page">Shopping Cart</a>
                                </li>
                                @if ($user->hasPermissionTo('orderHistory'))
                                    <li class="me-2">
                                        <a href="{{ route('order') }}"
                                            class="inline-block p-4 rounded-t-lg <?php if (Request::is('order')) {
                                                echo 'text-[#000] border-b-[3px] active border-[#00838f]';
                                            } else {
                                                echo 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300';
                                            } ?>">Order Lookup</a>
                                    </li>
                                @endif
                                <li class="me-2">
                                    <a href="{{ route('profile.edit') }}"
                                        class="inline-block p-4 rounded-t-lg <?php if (Request::is('profile')) {
                                            echo 'text-[#000] border-b-[3px] active border-[#00838f]';
                                        } else {
                                            echo 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300';
                                        } ?>">My Account</a>
                                </li>
                                <li class="me-2">
                                    <a href="{{ route('quotes') }}"
                                        class="inline-block p-4 rounded-t-lg <?php if (Request::is('quotes')) {
                                            echo 'text-[#000] border-b-[3px] active border-[#00838f]';
                                        } else {
                                            echo 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300';
                                        } ?>">Quotes</a>
                                </li>

                                <li class="me-2">
                                    <a href="{{ route('link-account') }}"
                                        class="inline-block p-4 rounded-t-lg <?php if (Request::is('link-account')) {
                                            echo 'text-[#000] border-b-[3px] active border-[#00838f]';
                                        } else {
                                            echo 'border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300';
                                        } ?>">Link Account</a>
                                </li>
                            </ul>
                        </div>

                        @unless (request()->routeIs('dashboard'))
                            <x-customer-switcher />
                        @endunless
                    </div>

                </div>
            </div>
        </section>
    @endauth
@endif
