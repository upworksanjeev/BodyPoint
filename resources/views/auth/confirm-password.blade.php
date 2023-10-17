<x-mainpage-layout>
    <!-- Session Status -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 pb-10 mt-4 sm:pt-0 bg-[#F8F8F8] ">

   
<div class="w-full  sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-lg overflow-hidden sm:rounded-lg">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>
</x-mainpage-layout>
