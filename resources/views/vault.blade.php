<x-mainpage-layout>

    <div class="min-h-[62vh] bg-[#f6f6f6]">
        <section class="bg-[#00838F] text-[#ffffff] px-10">
            <div class="container mx-auto py-9">
                <h2 class="text-5xl font-400 leading-tight">Partner Vault</h2>
            </div>
        </section>
        <section class="">
            <div class="max-w-[1170px] mx-auto py-20">
                <div class="lg:grid grid-cols-2 gap-8">
                    <div>
                        <div>
                            <h2 class="text-3xl font-normal mb-4">
                                Welcome to Partner Vault
                            </h2>
                            <p class="text-lg font-normal mb-4">Partner Resource Central</p>
                            <iframe class="rounded-2xl"
                                src="https://www.youtube.com/embed/XHOmBV4js_E?controls=1&rel=0&playsinline=0&modestbranding=0&autoplay=0&enablejsapi=1&origin=https%3A%2F%2Fbodypoint.dev&widgetid=1"
                                width="100%" height="360" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class="bg-white rounded-2xl mt-8 border border-[#E9E9E9]">
                            <div class="p-6 border-b border-[#E9E9E9]">
                                <h2 class="text-3xl mb-4">Review My Document</h2>
                                <p class="text-lg font-normal">
                                    Send the Bodypoint Marketing Team your file for review here!
                                    Response time is typically less then 2 business days!
                                </p>
                            </div>
                            <div class="py-6 px-7">
                                <form>
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
                                            <input id="dropzone-file" type="file" class="hidden" />
                                        </label>
                                    </div>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="first_name"
                                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Expected
                                                Launch Date
                                            </label>
                                            <input type="text" id=""
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="03-05-2024" required />
                                        </div>
                                        <div>
                                            <label for=""
                                                class="block mb-2 text-base font-medium text-gray-900">Company
                                                Name</label>
                                            <input type="text" id=""
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="Company Name" required />
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <label for=""
                                            class="block mb-2 text-base font-medium text-gray-900">Contact Name</label>
                                        <input type="text" id=""
                                            class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            placeholder="Contact Name" required />
                                    </div>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="first_name"
                                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Phone
                                            </label>
                                            <input type="text" id=""
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="Enter Your Phone" required />
                                        </div>
                                        <div>
                                            <label for=""
                                                class="block mb-2 text-base font-medium text-gray-900">Email</label>
                                            <input type="text" id=""
                                                class="bg-[#F6F6F6] border border-[#EAEAEA] text-gray-900 text-sm rounded focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5"
                                                placeholder="Enter Your Email" required />
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="message"
                                            class="block mb-2 text-sm font-medium text-gray-900">Message</label>
                                        <textarea id="message" rows="4"
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
                    <div class="mt-20">
                        <div class="accordion bg-white rounded-2xl">
                            <div class="accordion-item border border-[#E9E9E9] rounded-t-2xl">
                                <div
                                    class="accordion-item-headers accordion-item-headers-first flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Frequently Used Files
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Catalog_product_guide_BMM002_Volume_8.4_HI_RES.pdf"
                                                    target="_blank" class="text-[15px] text-[#00A8B8] font-normal">Product
                                                    Guide</a>
                                            </li>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Dynamic-Arm-Support-Brochure-BMM343-2022.4.pdf"
                                                    target="_blank" class="text-[15px] text-[#00A8B8] font-normal">Dynamic
                                                    Arm Support Brochure</a>
                                            </li>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Essentials_Hip_Belt_Sell_Sheet_-BMM337_2023.4.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Essential Hip Belt Sell
                                                    Sheet</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0">
                                <div
                                    class="accordion-item-headers flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Newly Added
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Catalog_product_guide_BMM002_Volume_8.4_HI_RES.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Product Guide</a>
                                            </li>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Dynamic-Arm-Support-Brochure-BMM343-2022.4.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Dynamic Arm Support
                                                    Brochure</a>
                                            </li>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Essentials_Hip_Belt_Sell_Sheet_-BMM337_2023.4.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Essential Hip Belt
                                                    Sell Sheet</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border border-[#E9E9E9] border-t-0 rounded-b-2xl">
                                <div
                                    class="accordion-item-headers flex items-center justify-between p-5 cursor-pointer relative text-base font-medium">
                                    Media Assets
                                </div>
                                <div class="accordion-item-body overflow-hidden max-h-0">
                                    <div
                                        class="accordion-item-body-content p-4 leading-normal border-t border-[#E9E9E9]">
                                        <ul>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Catalog_product_guide_BMM002_Volume_8.4_HI_RES.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Product Guide</a>
                                            </li>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Dynamic-Arm-Support-Brochure-BMM343-2022.4.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Dynamic Arm Support
                                                    Brochure</a>
                                            </li>
                                            <li>
                                                <a href="https://bodypoint.dev/wp-content/uploads/2024/07/Essentials_Hip_Belt_Sell_Sheet_-BMM337_2023.4.pdf"
                                                    target="_blank"
                                                    class="text-[15px] text-[#00A8B8] font-normal">Essential Hip Belt
                                                    Sell Sheet</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 py-4">
                            <img src="https://bodypoint.dev/wp-content/uploads/2024/06/Vector-10.svg"
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
      const accordionItemHeaders = document.querySelectorAll(
        ".accordion-item-headers"
      );

      accordionItemHeaders.forEach((accordionItemHeader) => {
        accordionItemHeader.addEventListener("click", (event) => {
          // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

              const currentlyActiveAccordionItemHeader = document.querySelector(".accordion-item-headers.active");
              if(currentlyActiveAccordionItemHeader && currentlyActiveAccordionItemHeader!==accordionItemHeader) {
                 currentlyActiveAccordionItemHeader.classList.toggle("active");
                 currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
               }

          accordionItemHeader.classList.toggle("active");
          const accordionItemBody = accordionItemHeader.nextElementSibling;
          if (accordionItemHeader.classList.contains("active")) {
            accordionItemBody.style.maxHeight =
              accordionItemBody.scrollHeight + "px";
          } else {
            accordionItemBody.style.maxHeight = 0;
          }
        });
      });
    </script>
</x-mainpage-layout>
