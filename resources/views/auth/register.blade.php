<x-mainpage-layout>
    <!-- Session Status -->
    <div class="min-h-[65vh]  flex flex-col sm:justify-center items-center pt-10 pb-10 mt-4 sm:pt-0 ">

   
    <div class="w-full  sm:max-w-xl mt-0 md:mt-10 px-5 md:px-10 py-6 shadow-lg overflow-hidden sm:rounded-lg bg-[#f6f6f6]">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="step" data-step="1" >
                <div class="text-xl text-[#00838f] pt-5 pb-7 text-center">{{ __('New User Registration') }}</div>
                
                <div class="flex flex-wrap	">
                    <!-- Name -->
                    <div class="w-full md:w-2/4  pr-0 md:pr-2">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" required class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 md:mt-0">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" required class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="w-full md:w-2/4 pr-0 md:pr-2 mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" required />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="w-full md:w-2/4  pl-0 md:pl-2 mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" required  />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="w-full md:w-2/4 pr-0 md:pr-2 mt-4">
                        <x-input-label for="syspro_customer_id" :value="__('Customer ID')" />
                        <x-text-input id="syspro_customer_id" class="block mt-1 w-full "  name="syspro_customer_id" :value="old('syspro_customer_id')" required autofocus autocomplete="customer_number"  />
                        <x-input-error :messages="$errors->get('syspro_customer_id')" class="mt-2" />
                    </div>

                    {{-- <div class="w-full md:w-2/4 pr-0 md:pr-2 mt-4">
                        <x-input-label for="primary_phone" :value="__('Primary Phone')" />

                        <x-text-input id="primary_phone" class="block mt-1 w-full"
                                        type="number"
                                        name="primary_phone"  :value="old('primary_phone')"  autofocus autocomplete="primary_phone"  />

                        <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                    </div>


                    <div class="w-full md:w-2/4  pl-0 md:pl-2 mt-4">
                        <x-input-label for="alternate_phone" :value="__('Alternate Phone')" />

                        <x-text-input id="alternate_phone" class="block mt-1 w-full"
                                        type="number"
                                        name="alternate_phone" :value="old('alternate_phone')"  autofocus autocomplete="alternate_phone"/>

                        <x-input-error :messages="$errors->get('alternate_phone')" class="mt-2" />
                    </div> --}}
                </div>
        
        </div>


         <!-- Step 2 -->
        <div class="step" data-step="2">

            <div class="py-6 text-xl text-[#00838f] pt-5 pb-7 text-center">{{ __('Company Information') }}</div>    
            
                <div class="mt-4">
                    <x-input-label for="customer_number" :value="__('Customer Number')" />
                    <x-text-input id="customer_number" class="block mt-1 w-full "  name="customer_number" :value="old('customer_number')" required autofocus autocomplete="customer_number"  />
                    <x-input-error :messages="$errors->get('customer_number')" class="mt-2" />
                </div>
                <!-- Other fields for step 2 -->

        </div>

     <!-- Step 3 -->
     <div class="step" data-step="3">

        <div class="py-6 text-xl text-[#00838f] pt-5 pb-7 text-center ">{{ __('Shipping Information') }}</div>    
        
        <div class="flex flex-wrap">
            <div class="w-full md:w-2/4  pr-0 md:pr-2">
                <x-input-label for="shipping_user_name" :value="__('Name')" />
                <x-text-input id="shipping_user_name" required   class="block mt-1 w-full" type="text" name="shipping_user_name" :value="old('shipping_user_name')"  autofocus autocomplete="shipping_user_name" />
                <x-input-error :messages="$errors->get('shipping_user_name')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 md:mt-0">
                <x-input-label for="shipping_last_name" :value="__('Last Name')" />
                <x-text-input id="shipping_last_name" required   class="block mt-1 w-full" type="text" name="shipping_last_name" :value="old('shipping_last_name')"  autofocus autocomplete="shipping_last_name"  />
                <x-input-error :messages="$errors->get('shipping_last_name')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4  pr-0 md:pr-2 mt-4 ">
                <x-input-label for="shipping_address" :value="__('Address')" />
                <x-text-input id="shipping_address" required   class="block mt-1 w-full" type="text" name="shipping_address" :value="old('shipping_address')"  autofocus autocomplete="shipping_address" />
                <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 ">
                <x-input-label for="shipping_city" :value="__('City')" />
                <x-text-input id="shipping_city" required  class="block mt-1 w-full" type="text" name="shipping_city" :value="old('shipping_city')"   autofocus autocomplete="shipping_city" />
                <x-input-error :messages="$errors->get('shipping_city')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4  pr-0 md:pr-2 mt-4 ">
                <x-input-label for="shipping_state" :value="__('State')" />
                <x-text-input id="shipping_state" required   class="block mt-1 w-full" type="text" name="shipping_state" :value="old('shipping_state')"  />
                <x-input-error :messages="$errors->get('shipping_state')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4">
                <x-input-label for="shipping_zip" :value="__('Zip')" />
                <x-text-input id="shipping_zip" required  class="block mt-1 w-full" type="text" name="shipping_zip" :value="old('shipping_zip')"  autofocus autocomplete="shipping_zip"   />
                <div id="output" class="text-red-500"></div>
                <x-input-error :messages="$errors->get('shipping_zip')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4  pr-0 md:pr-2 mt-4 ">
                <x-input-label for="shipping_country" :value="__('Country')" />
                <x-select id="shipping_country"  name="shipping_country" :value="old('shipping_country')" autofocus autocomplete="shipping_country" >
                <x-slot name="content">
                <option >Select Country</option>
                    @foreach ($countries as $country)
                                    <option value="{{lcfirst($country->name)}}"  class="block mt-1 w-full"  @selected(old('shipping_country') == lcfirst($country->name))>{{$country->name}}</option>
                                @endforeach
                    </x-slot>
                </x-select>
                <x-input-error :messages="$errors->get('shipping_country')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 ">
                <x-input-label for="shipping_phone" :value="__('Phone')" />
                <x-text-input id="shipping_phone"  class="block mt-1 w-full" type="number" name="shipping_phone" :value="old('shipping_phone')" autofocus autocomplete="shipping_phone"  />
                <x-input-error :messages="$errors->get('shipping_phone')" class="mt-2" />
            </div>
        </div>
        <!-- Other fields for step 3 -->

    
    
        <div class="card flex items-center mt-4 justify-between">
            <div class="py-6 text-xl text-[#00838f] ">{{ __('Billing Information') }}</div>   
            
            <div class="flex ml-4 pt-[5px] pr-2" >
                <x-text-input id="shipping_details"    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-0" type="checkbox"  name="shipping_details" :value="old('shipping_details')" />
                <x-input-label  for="shipping_details" class="ml-2 text-sm font-medium text-gray-900" for="" :value="__('Same As Shipping Address')" />
            </div>

        
        </div>

        <div class="flex flex-wrap">
            <div class="w-full md:w-2/4  pr-0 md:pr-2">
                <x-input-label for="billing_user_name" :value="__('Name')" />
                <x-text-input id="billing_user_name" required   class="block mt-1 w-full" type="text" name="billing_user_name" :value="old('billing_user_name')"  autofocus autocomplete="billing_user_name" />
                <x-input-error :messages="$errors->get('billing_user_name')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 md:mt-0" >
                <x-input-label for="billing_last_name" :value="__('Last Name')" />
                <x-text-input id="billing_last_name" required   class="block mt-1 w-full" type="text" name="billing_last_name" :value="old('billing_last_name')"  autofocus autocomplete="billing_last_name"  />
                <x-input-error :messages="$errors->get('billing_last_name')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4  pr-0 md:pr-2  mt-4">
                <x-input-label for="billing_address" :value="__('Address')" />
                <x-text-input id="billing_address" required   class="block mt-1 w-full" type="text" name="billing_address" :value="old('billing_address')"   />
                <x-input-error :messages="$errors->get('billing_address')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4">
                <x-input-label for="billing_city" :value="__('City')" />
                <x-text-input id="billing_city" required   class="block mt-1 w-full" type="text" name="billing_city" :value="old('billing_city')"  />
                <x-input-error :messages="$errors->get('billing_city')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4  pr-0 md:pr-2  mt-4">
                <x-input-label for="billing_state" :value="__('State')" />
                <x-text-input id="billing_state" required   class="block mt-1 w-full" type="text" name="billing_state" :value="old('billing_state')"  />
                <x-input-error :messages="$errors->get('billing_state')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4">
                <x-input-label for="billing_zip" :value="__('Zip')" />
                <x-text-input id="billing_zip"   required   class="block mt-1 w-full" type="text" name="billing_zip" :value="old('billing_zip')"   autofocus autocomplete="billing_zip"   />
                <div id="billing_output" class="text-red-500"></div>
                <x-input-error :messages="$errors->get('billing_zip')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4  pr-0 md:pr-2  mt-4">
                <x-input-label for="billing_country" :value="__('Country')" />
                <x-select id="billing_country"   name="billing_country" :value="old('billing_country')">
                    <x-slot name="content">
                    <option>Select Country</option>
                    @foreach ($countries as $country)
                                    <option value="{{lcfirst($country->name)}}"  class="block mt-1 w-full"  @selected(old('shipping_country') == lcfirst($country->name))>{{$country->name}}</option>
                                @endforeach
                    </x-slot>
                </x-select>
                <x-input-error :messages="$errors->get('billing_country')" class="mt-2" />
            </div>

            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4">
                <x-input-label for="billing_phone" :value="__('Phone')" />
                <x-text-input id="billing_phone"  class="block mt-1 w-full" type="number" name="billing_phone" :value="old('billing_phone')" autofocus autocomplete="billing_phone"    />
                <x-input-error :messages="$errors->get('billing_phone')" class="mt-2" />
            </div>
        </div>
    </div>
           
    <div class="flex items-center justify-end mt-4">
        {{-- <x-primary-button class="ml-4 prev-button focusver:">  {{ __('Previous') }} </x-primary-button>
        <x-primary-button class="ml-4 next-button focus:border-none ">{{ __('Next') }} </x-primary-button> --}}
        <x-primary-button class="ml-4 submit-button">
           {{ __('Register') }}
       </x-primary-button>
    
    </div>
    <div class="flex items-center justify-center mt-4">
    <a class="underline text-sm text-[#00838f] hover:text-[#00838f] rounded-md focus:outline-none focus:ring-0 focus:ring-offset-0" href="{{ route('login') }}">
                {{ __('Already Registered? Login here') }}
            </a>
    </div>

    </form>
</div>
</div>



</x-mainpage-layout>
