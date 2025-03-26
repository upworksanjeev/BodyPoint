<x-mainpage-layout>
    @section('title', 'Vault - '.config('app.name', 'Bodypoint'))
    <div class="min-h-[62vh] bg-[#f6f6f6]">
        <section class="bg-[#00838F] text-[#ffffff] px-6 lg:px-10">
            <div class="lg:container mx-auto py-7 md:py-9">
                <h2 class="text-[32px] md:text-5xl font-400 leading-tight">Partner Vault</h2>
            </div>
        </section>
        <section class="">
            <div class="max-w-[1170px] mx-auto py-8 md:py-16 px-6">
                <div class="md:grid grid-cols-2 gap-4 md:gap-8">
                    <div>
                        <div>
                            <h2 class="text-3xl font-normal mb-2 md:mb-4">
                                Welcome to Partner Vault
                            </h2>
                            <p class="text-lg font-normal mb-4">Partner Resource Central</p>
                            <div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://www.loom.com/embed/b979abfe91fc4da2aaf4b253ea39c5ab?sid=e05789c7-9721-4614-a133-0d19dc64ceb9" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe></div>
                        </div>
                        <div class="bg-white rounded-2xl mt-8 border border-[#E9E9E9]">
                            <div class="p-6 border-b border-[#E9E9E9]">
                                <h2 class="text-3xl md-3 md:mb-4">Review My Document</h2>
                                <p class="text-lg font-normal">
                                    Send the Bodypoint Marketing Team your file for review here!
                                    Response time is typically less then 2 business days!
                                </p>
                            </div>
                            <div class="py-6 px-7">
                                <form method="post" action="{{route('post-vault')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex items-start flex-col justify-center w-full mb-6">
                                        <label for="first_name"
                                            class="block mb-2 text-base font-medium text-gray-900">First name</label>
                                        <label for="dropzone-file"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#00838F] border-dashed rounded-lg cursor-pointer bg-[#F1FAFF]">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500">
                                                    <span class="font-semibold">Click to upload</span> or
                                                    drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    SVG, PNG, JPG or GIF (MAX. 800x400px)
                                                </p>
                                            </div>
                                            <input id="dropzone-file" type="file" name="attachment" class="hidden" />
                                        </label>
                                    </div>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="first_name"
                                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Expected
                                                Launch Date
                                            </label>
                                            <input type="text" id="datepicker-format" datepicker datepicker-format="dd-mm-yyyy" name="date"
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="03-05-2024" required />
                                        </div>
                                        <div>
                                            <label for=""
                                                class="block mb-2 text-base font-medium text-gray-900">Company
                                                Name</label>
                                            <input type="text" id="" name="company_name"
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="Company Name" required />
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <label for=""
                                            class="block mb-2 text-base font-medium text-gray-900">Contact Name</label>
                                        <input type="text" id="" name="contact_name"
                                            class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            placeholder="Contact Name" required />
                                    </div>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="first_name"
                                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Phone
                                            </label>
                                            <input type="text" id="" name="phone" pattern="[0-9]{10}"
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="Enter Your Phone" required />
                                        </div>
                                        <div>
                                            <label for=""
                                                class="block mb-2 text-base font-medium text-gray-900">Email</label>
                                            <input type="email" id="" name="email"
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="Enter Your Email" required />
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="message"
                                            class="block mb-2 text-sm font-medium text-gray-900">Message</label>
                                        <textarea id="message" rows="4" name="message"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-[#F6F6F6] border border-[#EAEAEA] rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit"
                                            class="text-white bg-[#00838F] hover:bg-[#00838F] font-medium rounded-[5px] text-base uppercase w-full ml-auto sm:w-auto px-5 py-2.5 text-center">
                                            Send For Review
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-20">
                        <div class="accordion bg-white rounded-2xl">
                            <div class="accordion-item border border-[#E9E9E9] rounded-t-2xl">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav accordion-item-headers-first flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Frequently Used Files
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($frequently_user_files as $file)
                                                <li>
                                                    <a href="{{ url($file['url']) }}" target="_blank"
                                                        class="text-[15px] text-[#00838F] font-normal">
                                                        {{ $file['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Newly Added
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($newly_added as $file)
                                                <li>
                                                    <a href="{{ url($file['url']) }}" target="_blank"
                                                        class="text-[15px] text-[#00838F] font-normal">
                                                        {{ $file['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0 ">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Media Assets
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content py-[20px] px-7 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($media_assets as $key =>  $files)
                                                <li>
                                                    <div class="accordion-item">
                                                        <div
                                                            class="accordion-item-headers accordion-item-headers-inner accordion-item-headers-first flex items-center justify-between ps-8 pb-4 cursor-pointer relative text-base font-medium">
                                                            {{ $key }}
                                                        </div>
                                                        <div class="accordion-item-body max-h-full">
                                                            <div
                                                                class="accordion-item-body-content accordion-item-body-content-inner leading-normal mb-4">
                                                                <ul>
                                                                   @foreach ($files as $key =>  $file)
                                                                    <li>
                                                                        <a href="{{ url($file['url']) }}" target="_blank"
                                                                            class="text-[15px] text-[#00838F] font-normal">
                                                                            {{ $file['name'] }}
                                                                        </a>
                                                                    </li>
                                                                   @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Marketing Collateral
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($marketing_collateral as $key =>  $files)
                                                <li>
                                                    <div class="accordion-item">
                                                        <div
                                                            class="accordion-item-headers accordion-item-headers-inner accordion-item-headers-first flex items-center justify-between ps-8 pb-4 cursor-pointer relative text-base font-medium">
                                                            {{ $key }}
                                                        </div>
                                                        <div class="accordion-item-body overflow-hidden max-h-0">
                                                            <div
                                                                class="accordion-item-body-content accordion-item-body-content-inner leading-normal mb-4">
                                                                <ul>
                                                                   @foreach ($files as $key =>  $file)
                                                                    <li>
                                                                        <a href="{{ url($file['url']) }}" target="_blank"
                                                                            class="text-[15px] text-[#00838F] font-normal">
                                                                            {{ $file['name'] }}
                                                                        </a>
                                                                    </li>
                                                                   @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if($pricing_guide)
                             <div class="accordion-item border border-[#E9E9E9] border-t-0">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Pricing Guide
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($pricing_guide as $file)
                                                <li>
                                                    <a href="{{ url($file['url']) }}" target="_blank"
                                                        class="text-[15px] text-[#00838F] font-normal">
                                                        {{ $file['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                             <div class="accordion-item border border-[#E9E9E9] border-t-0">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Presentations
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($presentations as $file)
                                                <li>
                                                    <a href="{{ url($file['url']) }}" target="_blank"
                                                        class="text-[15px] text-[#00838F] font-normal">
                                                        {{ $file['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0 ">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Product and Technical
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            @foreach ($product_and_technical as $key =>  $filesCategories)
                                                <li>
                                                    <div class="accordion-item">
                                                        <div
                                                            class="accordion-item-headers accordion-item-headers-inner accordion-item-headers-first flex items-center justify-between ps-8 pb-4 cursor-pointer relative text-base font-medium">
                                                            {{ $key }}
                                                        </div>
                                                        <div class="accordion-item-body overflow-hidden max-h-0">
                                                            <div
                                                                class="accordion-item-body-content accordion-item-body-content-inner leading-normal">
                                                                <ul>
                                                                   @foreach ($filesCategories as $categoryKey =>  $category)
                                                                    <li>
                                                                         <div class="accordion-item px-4">
                                                                                <div
                                                                                    class="accordion-item-headers accordion-item-headers-innerchild accordion-item-headers-first flex items-center justify-between ps-8 pb-4 cursor-pointer relative text-base font-medium">
                                                                                    {{ $categoryKey }}
                                                                                </div>
                                                                                <div class="accordion-item-body overflow-hidden max-h-0">
                                                                                    <div
                                                                                        class="accordion-item-body-content accordion-item-body-content-inner leading-normal">
                                                                                        <ul>
                                                                                        @foreach ($category as  $file)
                                                                                            <li>
                                                                                                <a href="{{ url($file['url']) }}" target="_blank"
                                                                                                    class="text-[15px] text-[#00838F] font-normal">
                                                                                                    {{ $file['name'] }}
                                                                                                </a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </li>
                                                                   @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0 rounded-b-2xl">
                                <div
                                    class="accordion-item-headers accordion-item-headers-nav flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Active Campaigns
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content leading-normal border-t border-[#E9E9E9]">
                                        <ul class="active_campaigns py-1 px-[14px]">
                                            @foreach ($active_campaigns as $file)
                                                <li>
                                                    <a href="{{ url($file['image']) }}" target="_blank"
                                                        class="text-[15px] text-[#00838F] font-normal">
                                                        <img decoding="async" src="{{ url($file['image']) }}">
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 py-4">
                            <img src="https://bodypoint.com/wp-content/uploads/2024/06/Vector-10.svg"
                                alt="question" />
                            <p class="text-base font-normal m-0">
                                Need Assistance? Email our Marketing Team
                                <a href="#!" class="text-[#00838F]"><b>Here</b></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    function setupAccordion(accordionHeaders, parentClass) {
        accordionHeaders.forEach((header) => {
            header.addEventListener("click", (event) => {
                // Close other active accordions at the same level
                const currentlyActive = document.querySelector(
                    `.${parentClass}.active`
                );
                if (currentlyActive && currentlyActive !== header) {
                    currentlyActive.classList.remove("active");
                    currentlyActive.nextElementSibling.style.maxHeight = 0;
                }

                // Toggle current accordion
                header.classList.toggle("active");
                const body = header.nextElementSibling;

                if (header.classList.contains("active")) {
                    body.style.maxHeight = body.scrollHeight + "px";
                    updateParentHeight(header);
                } else {
                    body.style.maxHeight = 0;
                    updateParentHeight(header, true);
                }
            });
        });
    }

    function updateParentHeight(element, isClosing = false) {
        let parentBody = element.closest(".accordion-item-body");
        while (parentBody) {
            if (isClosing) {
                parentBody.style.maxHeight = parentBody.scrollHeight - element.nextElementSibling.scrollHeight + "px";
            } else {
                parentBody.style.maxHeight = parentBody.scrollHeight + element.nextElementSibling.scrollHeight + "px";
            }
            parentBody = parentBody.parentElement.closest(".accordion-item-body");
        }
    }

    setupAccordion(
        document.querySelectorAll(".accordion-item-headers-nav"),
        "accordion-item-headers-nav"
    );
    setupAccordion(
        document.querySelectorAll(".accordion-item-headers-inner"),
        "accordion-item-headers-inner"
    );
    setupAccordion(
        document.querySelectorAll(".accordion-item-headers-innerchild"),
        "accordion-item-headers-innerchild"
    );
});

    </script>
</x-mainpage-layout>

