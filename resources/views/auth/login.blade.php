<x-mainpage-layout>
    <!-- Session Status -->
    <div class="h-[65vh] sm:h-[62.5vh] p-5 flex sm:justify-center items-center mt-4 sm:pt-0">
        <div class="w-full sm:max-w-xl px-10 py-10 shadow-lg overflow-hidden sm:rounded-lg bg-[#f6f6f6]">
            <!-- Display Session Status if any -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" @submit.prevent x-data="loginHandler()">
                @csrf

                <div x-show="step === 'email'">
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" x-model="email" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4 text-right">
                        <x-primary-button class=" text-xs" @click.prevent="login">
                            {{ __('Continue') }}
                        </x-primary-button>
                    </div>
                </div>

                <div x-show="step === 'password'" class="mt-4">
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" x-model="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-4 text-right">
                        <x-primary-button class="ml-3 text-xs" @click.prevent="checkPassword">
                            {{ __('Login') }}
                        </x-primary-button>
                    </div>
                </div>

                <div x-show="step === 'set-password'" class="mt-4">
                    <div>
                        <x-input-label for="new-password" :value="__('New Password')" />
                        <x-text-input id="new-password" class="block mt-1 w-full" type="password" x-model="newPassword" required />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="confirm-password" :value="__('Confirm Password')" />
                        <x-text-input id="confirm-password" class="block mt-1 w-full" type="password" x-model="confirmPassword" required />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <div class="mt-4 text-right">
                        <x-primary-button class="ml-3 text-xs" @click.prevent="setPassword">
                            {{ __('Set Password') }}
                        </x-primary-button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Forgot Password Link -->
                <div class="flex items-center sm:justify-end justify-center mt-2">
                    @if (Route::has('password.request'))
                        <a class="text-[#00838f] underline text-xs sm:text-sm rounded-md focus:outline-none" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <script>
        function loginHandler() {
            return {
                step: 'email',
                email: '',
                password: '',
                newPassword: '',
                confirmPassword: '',
                login() {
                    $.ajax({
                        url: '{{ route('login') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { email: this.email },
                        success: (data) => {
                            if (data.status === 'exists') {
                                this.step = 'password';
                            } else if (data.status === 'new') {
                                this.step = 'set-password';
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message);
                            }
                        },
                        error: (xhr) => {
                            this.handleErrors(xhr);
                        }
                    });
                },

                checkPassword() {
                    $.ajax({
                        url: '{{ route('check-password') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { email: this.email, password: this.password },
                        success: (data) => {
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                window.location.href = '/dashboard';
                            } else {
                                toastr.error(data.message);
                            }
                        },
                        error: (xhr) => {
                            this.handleErrors(xhr);
                        }
                    });
                },

                setPassword() {
                    $.ajax({
                        url: '{{ route('set-password') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: this.email,
                            password: this.newPassword,
                            password_confirmation: this.confirmPassword
                        },
                        success: (data) => {
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                window.location.href = '/dashboard';
                            } else {
                                toastr.error(data.message);
                            }
                        },
                        error: (xhr) => {
                            this.handleErrors(xhr);
                        }
                    });
                },
                handleErrors(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    } else if (xhr.status === 500) {
                        toastr.error('An internal server error occurred. Please try again.');
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                }
            }
        }
    </script>
</x-mainpage-layout>
