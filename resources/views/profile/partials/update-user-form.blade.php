<section class="px-3">
    <header>
        <h2 class="text-[18px] md:text-[26px] text-[#00838f] font-bold text-center">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 text-center">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <div class="w-full sm:max-w-xl mt-3 md:mt-7 px-6 py-8 overflow-hidden border border-[#c0c0c04f] rounded-lg bg-[#fff]">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
         @csrf
        </form>
            <form id="registrationForm"  method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="step" data-step="1">
                        <div class="text-xl text-[#00838f] pb-5 text-center">{{ __('Contact Information') }}</div>

                        <div class="flex flex-wrap	">
                            <!-- Name -->
                            <div class="w-full md:w-2/4  pr-0 md:pr-2">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" required class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)"  autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="w-full md:w-2/4 pl-0 md:pl-2 mt-4 md:mt-0">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" required class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)"  autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            @php
                                $customer = getCustomer();
                            @endphp
                            @if($customer->hasPermissionTo('updatePassword'))
                                <!-- Password -->
                                <div class="w-full md:w-2/4 pr-0 md:pr-2 mt-4">
                                    <x-input-label for="password" :value="__('Password')" />

                                    <x-text-input id="password" class="block mt-1 w-full"
                                                    type="password"
                                                    name="password"
                                                    autocomplete="new-password"  />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="w-full md:w-2/4  pl-0 md:pl-2 mt-4">
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                    type="password"
                                                    name="password_confirmation"  autocomplete="new-password"   />

                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            @endif

                            <div class="w-full md:w-2/4 pr-0 md:pr-2 mt-4">
                                <x-input-label for="primary_phone" :value="__('Primary Phone')" />

                                <x-text-input id="primary_phone" class="block mt-1 w-full"
                                                type="number"
                                                name="primary_phone"  :value="old('primary_phone', isset($userDetail->primary_phone) ? str_replace('-', '', $userDetail->primary_phone) : $user->getUserDetails->primary_phone)"  autofocus autocomplete="primary_phone" />

                                <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                            </div>

                            <div class="w-full md:w-2/4  pl-0 md:pl-2 mt-4">
                                <x-input-label for="alternate_phone" :value="__('Alternate Phone')" />

                                <x-text-input id="alternate_phone" class="block mt-1 w-full"
                                                type="number"
                                                name="alternate_phone" :value="old('alternate_phone', isset($userDetail->alternate_phone) ? str_replace('-', '', $userDetail->alternate_phone) : $user->getUserDetails->alternate_phone)"  autofocus autocomplete="alternate_phone"/>

                                <x-input-error :messages="$errors->get('alternate_phone')" class="mt-2" />
                            </div>

							<div class="w-full md:w-2/4 pr-0 md:pr-2 mt-4 profile_image">
                                <x-input-label for="profile_img" :value="__('Profile Image')" />

                                <x-text-input type="file" id="profile_img" class="block mt-1 w-full" name="profile_img"  autofocus autocomplete="profile_img" />

                                <x-input-error :messages="$errors->get('profile_img')" class="mt-2" />
                            </div>
                        </div>

                </div>


                {{-- <!-- Step 2 -->
                <div class="step" data-step="2">

                    <div class="py-6 text-xl text-[#00838f] pt-5 pb-7 text-center">{{ __('Company Information') }}</div>

                        <div class="mt-4">
                            <x-input-label for="customer_number" :value="__('Customer Number')" />
                            <x-text-input id="customer_number" class="block mt-1 w-full" name="customer_number" :value="old('customer_number' , $user->getUserDetails->customer_number)" required autofocus autocomplete="customer_number"  />
                            <x-input-error :messages="$errors->get('customer_number')" class="mt-2" />
                        </div>
                        <!-- Other fields for step 2 -->

                </div> --}}

                    <div class="flex items-center justify-end mt-4">
                        {{-- <x-primary-button class="ml-4 prev-button capitalize font-extralight focus:border-none">  {{ __('Previous') }} </x-primary-button> --}}
                        {{-- <x-primary-button id="profile-update-next-btn" class="ml-4 next-button capitalize font-extralight focus:border-none">{{ __('Next') }} </x-primary-button> --}}
                        <x-primary-button class="ml-4 submit-button capitalize font-extralight focus:border-none">
                        {{ __('Update Profile') }}
                        </x-primary-button>

                    </div>

            </form>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
    </div>

</section>
