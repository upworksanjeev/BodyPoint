<x-mainpage-layout>
    <!-- Session Status -->
    <div class="h-[65vh] sm:h-[62.5vh]  p-5 flex  sm:justify-center items-center  mt-4 sm:pt-0 ">

   
    <div class="w-full  sm:max-w-xl  px-10 py-10 shadow-lg overflow-hidden sm:rounded-lg bg-[#f6f6f6]  ">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 " name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center sm:justify-end  justify-center mt-4 ">
            @if (Route::has('password.request'))
                <a class="text-[#00838f] underline text-xs sm:text-sm  rounded-md focus:outline-none focus:ring-0 focus:ring-offset-0 focus:ring-0" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3 text-xs">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>
</x-mainpage-layout>
