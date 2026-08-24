<div class="bg-white rounded-2xl border border-[#E9E9E9]">
    <div class="p-6 border-b border-[#E9E9E9]">
        <h2 class="text-3xl md-3 md:mb-4">Review My Document</h2>
        <p class="text-lg font-normal">
            Send the Bodypoint Marketing Team your file for review here!
            Response time is typically less then 2 business days!
        </p>
    </div>
    <div class="py-6 px-7">
        <form method="post" action="{{ route('post-vault') }}" enctype="multipart/form-data">
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
                    <input type="text" id="datepicker-format" datepicker
                        datepicker-format="dd-mm-yyyy" name="date"
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
