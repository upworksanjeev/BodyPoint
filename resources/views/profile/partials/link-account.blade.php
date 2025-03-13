<section class="px-4">
    <header>
        <h2 class="text-[18px] md:text-[26px] text-[#00838f] font-bold text-center">
            {{ __('Account Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 text-center">
            {{ __("Link additional customer accounts") }}
        </p>
    </header>

    <div class="w-full sm:max-w-xl mt-3 md:mt-7 px-6 py-8 overflow-hidden border border-[#c0c0c04f] rounded-lg bg-[#f6f6f6]">
        
            <form id="registrationForm"  method="post" action="{{ route('post-link-account') }}" enctype="multipart/form-data">
                @csrf
                <div class="step" data-step="1">
                        <div class="text-xl text-[#00838f] pb-5 text-center">{{ __('Account Information') }}</div>

                        <div class="flex flex-wrap	">
                            <!-- Name -->
                            <div class="w-full md:w-2/4  pr-0 md:pr-2">
                                <x-input-label for="syspro_customer_id" :value="__('Customer Account Number')" />
                                <x-text-input id="syspro_customer_id" required class="block mt-1 w-full" type="text" name="syspro_customer_id" :value="old('syspro_customer_id')"  autofocus  oninput="this.value = this.value.toUpperCase()" />
                                <x-input-error :messages="$errors->get('syspro_customer_id')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 md:mt-0">
                                <x-input-label for="customer_name" :value="__('Account Nickname')" />
                                <x-text-input id="customer_name" required class="block mt-1 w-full" type="email" name="customer_name" :value="old('customer_name')"  />
                                <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                            </div>

                           
                        </div>

                </div>


                

                    <div class="flex items-center justify-end mt-4">
                       
                        <x-primary-button class="ml-4 submit-button capitalize font-extralight focus:border-none">
                        {{ __('Add account') }}
                        </x-primary-button>

                    </div>

            </form>
    </div>
     
     <div class="w-full sm:max-w-xl mt-6 px-6 py-8 overflow-hidden border border-gray-200 rounded-lg bg-white">
        <h3 class="text-lg text-[#00838f] font-bold mb-4">Linked Customer Accounts</h3>
        @if($customers->isNotEmpty())
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">Customer Account Number</th>
                        <th class="border px-4 py-2">Account Nickname</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customerAccount)
                        <tr>
                            <td class="border px-4 py-2">{{ $customerAccount->customer_id }}</td>
                            <td class="border px-4 py-2">{{ $customerAccount->name }}</td>
                            <td class="border px-4 py-2">
                                <!-- Unlink Form -->
                                <form action="{{ route('unlink-account', $customerAccount->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unlink this account?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Unlink
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-600">No customer accounts linked.</p>
        @endif
    </div>
</section>
