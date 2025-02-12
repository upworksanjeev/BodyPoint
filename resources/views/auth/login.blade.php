<x-mainpage-layout>
    <!-- Session Status -->
    <div class="pt-[32px] md:pt-[60px] px-4 flex sm:justify-center items-center">
        <div class="w-full sm:max-w-xl px-6 py-8 border border-[#c0c0c04f] overflow-hidden rounded-lg bg-[#f6f6f6]">
            <!-- Display Session Status if any -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" @submit.prevent x-data="loginHandler()">
                @csrf

                <div x-show="step === 'email'">
                    <div>
                        <x-input-label class="tex-sm font-semibold" for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-2 w-full" type="email" x-model="email" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4 text-right">
                        <x-primary-button class="text-sm capitalize font-mono font-extralight" @click.prevent="login">
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
                    <div class="mt-3 text-right">
                        <x-primary-button class="ml-3 text-xs" @click.prevent="checkPassword">
                            {{ __('Login') }}
                        </x-primary-button>

                        <!-- Forgot Password Link -->
                        <div class="flex items-center sm:justify-end justify-center mt-2">
                            @if (Route::has('password.request'))
                                <a class="text-[#00838f] underline text-xs sm:text-sm rounded-md focus:outline-none" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

            </form>
        </div>
    </div>
    <div class="py-[30px] md:py-[60px] px-4 flex justify-center">
        <div class="max-w-[900px] bg-[#00838F] p-[20px] md:p-[40px] rounded-xl flex justify-between items-baseline sm:items-center gap-4 md:gap-8 flex-wrap flex-col sm:flex-row">
            <div class="flex-1">
        <h1 class="text-[#fff] text-[18px] md:text-[24px] font-semibold mb-2 font-lato">Find a Partner</h1>
        <h2 class="text-[#fff] text-sm font-lato">Find a Bodypoint Partner near you! Bodypoint's worldwide partners sell our products, support our users and educate others about positioning.</h2>
    </div>
    <a class="capitalize text-sm text-[#fff] rounded-[50px] py-2 px-4 bg-[#FE7300] font-lato" href="{{ config('bodypoint.home_url') }}/find-a-partner-international">Partner Locator</a>
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
                            } else if (data.status === 'mail_sent') {
                                Swal.fire({
                                    title: 'Email Sent!',
                                    text: data.message,
                                    icon: 'success',
                                    iconColor: '#00838f',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'swal-button-color bg-[#00838f] px-6 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#00777f] focus:bg-[#00777f] active:bg-[#00777f] focus:outline-none focus:shadow-none focus-visible:shadow-none' // Correct syntax for focus-visible and removing shadows
                                    }
                                });
                            } else if(data.status === 'throttled') {
                                toastr.error(data.message);
                            }
                            else{
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
