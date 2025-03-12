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
                                <x-text-input id="syspro_customer_id" required class="block mt-1 w-full" type="text" name="syspro_customer_id" :value="old('syspro_customer_id')"  autofocus  />
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
    {{-- <hr> --}}

    <!-- Associate Customers List -->
    {{-- <h3>Existing Customers</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Syspro Customer ID</th>
                <th>Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->customer_id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->first_name }}</td>
                    <td>{{ $customer->last_name }}</td>
                    <td>
                        <!-- Edit Button -->
                        <form action="" method="POST" style="display:inline;">
                            @csrf
                            <input type="text" name="name" value="{{ $customer->name }}" required>
                            <input type="text" name="first_name" value="{{ $customer->first_name }}">
                            <input type="text" name="last_name" value="{{ $customer->last_name }}">
                        <button type="submit" class="btn btn-warning btn-sm">Update</button>
                        </form>

                        <!-- Delete Button -->
                        <form action="" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
</section>
