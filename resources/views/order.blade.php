<x-mainpage-layout>
    @section('title', 'Orders - '.config('app.name', 'Bodypoint'))
    <x-cart-nav />
    <section class="bg-[#F6F6F6] py-9">
        <header>
            <h2 class="text-lg text-[#00838f] font-bold text-center">
                All Orders
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-center">
                List of all your orders
            </p>
        </header>
        <div class="container mx-auto mt-9">
            <div class="max-w-screen-xl mx-auto px-4">
                <x-lookup.search-form
                    :action="route('order-search')"
                    :clear-url="route('order')"
                    :sync-url="route('sync-account', getCustomerId())"
                    sync-label="Sync Orders"
                    search-label="Search Orders"
                    search-button-name="search_order"
                    placeholder="Order No/ BP Number"
                    :search="$search ?? ''"
                    :start-date="$start_date ?? ''"
                    :end-date="$end_date ?? ''"
                />
                <div class="relative overflow-x-auto sm:rounded-2xl mt-5 md:mt-10" id="order_list">
                    <x-cart.order-list :order="$order" />
                </div>
                <div class="pt-4 md:pt-6 pb-2 text-right">
                    <a href="{{ route('home') }}" class="text-base text-[#00707B] font-normal leading-[18px] flex items-center justify-end gap-2">Continue Shopping
                        <x-icons.next-arrow />
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-mainpage-layout>
