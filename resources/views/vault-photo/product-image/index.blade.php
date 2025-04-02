<x-mainpage-layout>
    @if (session()->has('customer_po_number'))
        @php
            // dd(session()->get('customer_po_number') );
        @endphp
    @endif
    @section('title', 'Quotes - ' . config('app.name', 'Bodypoint'))
    {{-- <x-cart-nav /> --}}

    <div class="p-6 ctm-container mx-auto">
        <div class="flex items-center justify-center py-4 md:py-8 flex-wrap" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <button type="button" id="profile-tab" data-tabs-target="#profile" type="button" role="tab"
                aria-controls="profile" aria-selected="false"
                class="text-[#00838F] hover:text-white border border-[#00838F] bg-white hover:bg-[#00838F] focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">All
                categories</button>
            <button type="button" id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                aria-controls="dashboard" aria-selected="false"
                class="text-gray-900 border border-white hover:border-gray-200 bg-white focus:ring-4 focus:outline-none focus:ring-[#00838F] rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">Shoes</button>
            <button type="button" id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                aria-controls="settings" aria-selected="false"
                class="text-gray-900 border border-white hover:border-gray-200 bg-white focus:ring-4 focus:outline-none focus:ring-[#00838F] rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">Bags</button>
            <button type="button"
                class="text-gray-900 border border-white hover:border-gray-200 bg-white focus:ring-4 focus:outline-none focus:ring-[#00838F] rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">Electronics</button>
            <button type="button" id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                aria-controls="contacts" aria-selected="false"
                class="text-gray-900 border border-white hover:border-gray-200 bg-white focus:ring-4 focus:outline-none focus:ring-[#00838F] rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3">Gaming</button>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="grid grid-cols-4 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                        <div class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center">
                            <a href="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg"
                            download 
                                class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] min-w-[140px] max-w-[140px] text-center rounded-[10px]">Download</a>
                        </div>
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50" id="dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                <div class="grid grid-cols-4 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                        <div class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center">
                            <a href="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" target="_blank"
                                download
                                class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] min-w-[140px] max-w-[140px] text-center rounded-[10px]">Download</a>
                        </div>
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50" id="settings" role="tabpanel"
                aria-labelledby="settings-tab">
                <div class="grid grid-cols-4 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                        <div class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center">
                            <a href="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" target="_blank"
                                download
                                class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] min-w-[140px] max-w-[140px] text-center rounded-[10px]">Download</a>
                        </div>
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50" id="contacts" role="tabpanel"
                aria-labelledby="contacts-tab">
                <div class="grid grid-cols-4 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
                        <div class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center">
                            <a href="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" target="_blank"
                                download
                                class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] min-w-[140px] max-w-[140px] text-center rounded-[10px]">Download</a>
                        </div>
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg"
                            src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

    </div>


</x-mainpage-layout>
