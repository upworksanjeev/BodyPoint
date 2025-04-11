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
                <form action="{{ route('order-search') }}" method="post">
                    <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    <div class="grid gap-4 sm:gap-6 mb-6 lg:grid-cols-3">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search By:</label>
                            <input type="text" id="search_input" name="search_input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Order No/ BP Number" value="{{ $search??'' }}" />
                        </div>
                        <div>
                            {{-- <input id="datepicker-format" datepicker datepicker-min-date="02/26/2025" datepicker-max-date="03/05/2025" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date"> --}}
                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900">Order Date: </label>
                            <div date-rangepicker datepicker-max-date="{{ now()->format('m/d/Y') }}" class="flex items-center gap-3 sm:gap-0 flex-wrap lg:flex-nowrap">
                                <div class="relative w-full sm:w-auto">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.date />
                                    </div>
                                    <input name="start_date" id="start_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start" value="{{ $start_date??'' }}">
                                </div>
                                <span class="sm:mx-4 text-gray-500 my-1 sm:my-0 inline-block">to</span>
                                <div class="relative w-full sm:w-auto">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <x-icons.date />
                                    </div>
                                    <input name="end_date" id="end_date"   type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end" value="{{ $end_date??'' }}">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-0 lg:mt-5 gap-2 flex-wrap ">
                            <button type="submit" name="search_order" class="py-2.5 px-3 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 hover:bg-[#FF9119]/80 justify-center w-full sm:w-[124px] items-left">Search Order</button>
                            <a href="{{ route('order') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-right justify-center w-full sm:w-[124px]">Clear Search</a>
                            <button type="submit" name="download" class="py-2.5 px-3 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-full sm:w-[124px] ">Download</button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('sync-account', getCustomerId()) }}"
                                class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-full sm:w-[145px]">Sync Orders</a>
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
    @push('other-scripts')
    <script>
        // $(document).ready(function() {
           
        //     $('#start_date').on('change', function () {
        //         let startDate = $(this).val();
        //         $('#end_date').attr('data-min-date', startDate); 
        //     });
            
        // });
        
    </script>
    @endpush
</x-mainpage-layout>
