<x-mainpage-layout>
    <section class="py-[30px] md:py-[40px]">
        <div class="ctm-container">

            <div class="max-w-[900px] mx-auto flex flex-col items-center gap-6">
                <!-- Heading -->
                <p class="text-5xl font-bold text-center  text-gray-900">This page could not be found!</p>
                <!-- Description -->
                <p class="text-lg text-center text-gray-600  leading-relaxed">
                    We are sorry. But the page you are looking for is not available.<br>
                   
                </p>
            
                <!-- Search Form -->
                {{-- <form action="{{ route('product-search') }}" method="get" id="formsearch1" class="w-full max-w-md">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="relative flex items-center max-w-xs mx-auto w-full h-12  border ">
                        <input class="peer h-full w-full outline-none border-none focus:ring-0 text-sm text-gray-700 bg-[#f8f8f8]" 
                            type="text" id="searchinput1" name="searchinput" placeholder="Search..." />
                        <div style="right: 16px;" class="absolute right-4 grid place-items-center h-full cursor-pointer text-gray-500" id="searchicon">
                            <x-icons.search class="w-5 h-5"/>
                        </div>
                    </div>
                </form> --}}
            
                <!-- Back to Home Button -->
                <a href="/" style="background: #13aff0;" class="mt-6 inline-block bg-[#13aff0] text-white text-sm font-medium py-3 px-8 rounded-lg hover:bg-[#0d8bc2] transition duration-300">
                    BACK TO HOMEPAGE
                </a>
            </div>
            
            


        </div>
    </section>
</x-mainpage-layout>
