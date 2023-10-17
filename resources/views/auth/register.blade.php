<x-mainpage-layout>
    <!-- Session Status -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">

        <div>
            <a href="/">
                <x-application-logo class="block h-14 w-auto fill-current  text-gray-500" />
            </a>
        </div>
    <div class="w-full  sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="step" data-step="1">
                <div class="py-6 border-neutral-100 px-6 py-3 dark:border-neutral-600 dark:text-neutral-50">{{ __('Contact Information') }}</div>
                
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" required data-parsley-group="step-1" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" required data-parsley-group="step-1" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" required data-parsley-group="step-1" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" required data-parsley-group="step-1" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>


                <div class="mt-4">
                    <x-input-label for="primary_phone" :value="__('Primary Phone')" />

                    <x-text-input id="primary_phone" class="block mt-1 w-full"
                                    type="number"
                                    name="primary_phone"  data-parsley-group="step-1" />

                    <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                </div>


                <div class="mt-4">
                    <x-input-label for="alternate_phone" :value="__('Alternate Phone')" />

                    <x-text-input id="alternate_phone" class="block mt-1 w-full"
                                    type="number"
                                    name="alternate_phone"  data-parsley-group="step-1"/>

                    <x-input-error :messages="$errors->get('alternate_phone')" class="mt-2" />
                </div>
        
        </div>


         <!-- Step 2 -->
    <div class="step" data-step="2">

            <div class="py-6 border-neutral-100 px-6 py-3 dark:border-neutral-600 dark:text-neutral-50">{{ __('Company Information') }}</div>    
            
                <div>
                    <x-input-label for="customer_number" :value="__('Customer Number')" />
                    <x-text-input id="customer_number" class="block mt-1 w-full" type="text" name="customer_number" :value="old('customer_number')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('customer_number')" class="mt-2"  required data-parsley-group="step-2"/>
                </div>
                <!-- Other fields for step 2 -->

</div>

     <!-- Step 3 -->
     <div class="step" data-step="3">

        <div class="py-6 border-neutral-100 px-6 py-3 dark:border-neutral-600 dark:text-neutral-50">{{ __('Shipping Information') }}</div>    
     
        <div>
            <x-input-label for="shipping_user_name" :value="__('Name')" />
            <x-text-input id="shipping_user_name" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="shipping_user_name" :value="old('shipping_user_name')"  autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('shipping_user_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_last_name" :value="__('Last Name')" />
            <x-text-input id="shipping_last_name" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="shipping_last_name" :value="old('shipping_last_name')"   />
            <x-input-error :messages="$errors->get('shipping_last_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_address" :value="__('Address')" />
            <x-text-input id="shipping_address" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="shipping_address" :value="old('shipping_address')"   />
            <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_city" :value="__('City')" />
            <x-text-input id="shipping_city" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="shipping_city" :value="old('shipping_city')"  />
            <x-input-error :messages="$errors->get('shipping_city')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_state" :value="__('State')" />
            <x-text-input id="shipping_state" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="shipping_state" :value="old('shipping_state')"  />
            <x-input-error :messages="$errors->get('shipping_state')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_zip" :value="__('Zip')" />
            <x-text-input id="shipping_zip" required  data-parsley-group="step-3" class="block mt-1 w-full" type="number" name="shipping_zip" :value="old('shipping_zip')"   />
            <x-input-error :messages="$errors->get('shipping_zip')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_country" :value="__('Country')" />
            <x-select id="shipping_country"  name="shipping_country" :value="old('shipping_country')">
                <x-slot name="content">
                    <x-optionlist />
                </x-slot>
            </x-select>
            <x-input-error :messages="$errors->get('shipping_country')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_phone" :value="__('Phone')" />
            <x-text-input id="shipping_phone" data-parsley-group="step-3" class="block mt-1 w-full" type="number" name="shipping_phone" :value="old('shipping_phone')"   />
            <x-input-error :messages="$errors->get('shipping_phone')" class="mt-2" />
        </div>
        <!-- Other fields for step 3 -->

    
    
        <div class="card flex items-center">
            <div class="py-6 border-neutral-100 px-6 py-3 dark:border-neutral-600 dark:text-neutral-50">{{ __('Billing Information') }}</div>   
            
            <div class="flex items-center">
                <x-text-input id="shipping_details"    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox"  name="shipping_details" :value="old('shipping_details')" />
                <x-input-label  for="shipping_details" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="" :value="__('Same As Shipping Address')" />
            </div>

        
        </div>


        <div>
            <x-input-label for="billing_user_name" :value="__('Name')" />
            <x-text-input id="billing_user_name" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="billing_user_name" :value="old('billing_user_name')"  autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('billing_user_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="billing_last_name" :value="__('Last Name')" />
            <x-text-input id="billing_last_name" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="billing_last_name" :value="old('billing_last_name')"   />
            <x-input-error :messages="$errors->get('billing_last_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="billing_address" :value="__('Address')" />
            <x-text-input id="billing_address" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="billing_address" :value="old('billing_address')"   />
            <x-input-error :messages="$errors->get('billing_address')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="billing_city" :value="__('City')" />
            <x-text-input id="billing_city" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="billing_city" :value="old('billing_city')"  />
            <x-input-error :messages="$errors->get('billing_city')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="billing_state" :value="__('State')" />
            <x-text-input id="billing_state" required  data-parsley-group="step-3" class="block mt-1 w-full" type="text" name="billing_state" :value="old('billing_state')"  />
            <x-input-error :messages="$errors->get('billing_state')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="billing_zip" :value="__('Zip')" />
            <x-text-input id="billing_zip" required  data-parsley-group="step-3" class="block mt-1 w-full" type="number" name="billing_zip" :value="old('billing_zip')"   />
            <x-input-error :messages="$errors->get('billing_zip')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="shipping_country" :value="__('Country')" />
            <x-select id="billing_country"  name="shipping_country" :value="old('billing_country')">
                <x-slot name="content">
                    <x-optionlist />
                </x-slot>
            </x-select>
            <x-input-error :messages="$errors->get('billing_country')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="billing_phone" :value="__('Phone')" />
            <x-text-input id="billing_phone" data-parsley-group="step-3" class="block mt-1 w-full" type="number" name="billing_phone" :value="old('billing_phone')"   />
            <x-input-error :messages="$errors->get('billing_phone')" class="mt-2" />
        </div>
    
    </div>
           
    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4 prev-button focusver:">  {{ __('Previous') }} </x-primary-button>
        <x-primary-button class="ml-4 next-button">{{ __('Next') }} </x-primary-button>
        <x-primary-button class="ml-4 submit-button">
           {{ __('Register') }}
       </x-primary-button>
    
    </div>
    <div class="flex items-center justify-center mt-4">
    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
    </div>

    </form>

    <script>
    $(document).ready(function () {
    const $form = $('#registrationForm');
    const $steps = $form.find('.step');
    const $prevButton = $form.find('.prev-button');
    const $nextButton = $form.find('.next-button');

    let currentStep = 1;
     const totalSteps = $steps.length; // Pass the total steps from your controller
     

        // Function to validate the current step
        function validateStep() {
            const $currentStep = $steps.filter(':visible');
            const $requiredFields = $currentStep.find('[required]');
            let isValid = true;

            $requiredFields.each(function () {
                var $field = $(this);
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $field.addClass('border-red-600');
                }else{
                    $field.removeClass('border-red-600');
                }
            });

            return isValid;
        }
    $steps.not(':first').hide();

    if(currentStep === 1){
        $prevButton.hide();  
        $('.submit-button').hide();
    }
    
    $nextButton.click(function (e) {
            e.preventDefault();

            // Check if the current step is valid
            if (validateStep()) {
                const $currentStep = $steps.filter(':visible');
                const $nextStep = $currentStep.next('.step');
                $currentStep.hide();
                $prevButton.show();
                $nextStep.show();
                currentStep++;
                
                // Hide "Next" button on the last step and display "Register"
                if (currentStep === totalSteps) {
                    $nextButton.hide();
                    $('.submit-button').show();
                }
            } else {
        
            }
        });

        $prevButton.click(function (e) {
            e.preventDefault();
            const $currentStep = $steps.filter(':visible');
            const $prevStep = $currentStep.prev('.step');
            $currentStep.hide();
            $prevStep.show();
            currentStep--;

            // Show "Next" button when moving back to a previous step
            if (currentStep < totalSteps) {
                $nextButton.show();
                $prevButton.show();
                $('.submit-button').hide();
            }
        });

      
        // Assuming you have a checkbox element with the id "myCheckbox"
            const myCheckbox = document.getElementById('shipping_details');

            if (myCheckbox.checked) {
       
            } else {
                const $billingFields = $('.step[data-step="3"]').find('[name^="billing_"]');
                $billingFields.val('');
            }

        
        $('#shipping_details').change(function () {

            const $billingFields = $('.step[data-step="3"]').find('[name^="billing_"]');
            const $shippingFields = $('.step[data-step="3"]').find('[name^="shipping_"]');

            if (this.checked) {
                // Checkbox is checked, copy values from Shipping Information to Billing Information
                $billingFields.each(function (index, element) {
                    const billingFieldName = $(element).attr('name').replace('billing_', '');
                    const shippingField = $shippingFields.filter('[name="shipping_' + billingFieldName + '"]');
                    $(element).val(shippingField.val());
                });
            } else {
                // Checkbox is unchecked, clear Billing Information fields
                $billingFields.val('');
            }
        });

       
    
});

    </script>
</div>
</div>



</x-mainpage-layout>
