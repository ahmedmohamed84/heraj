<x-auth-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg max-w-xl mx-auto p-8">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">{{ __('Create New Account') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email or Phone -->
                <div class="mt-4">
                    <div class="flex justify-around">
                        <div class="flex items-center">
                            <input type="radio" id="register_with_email" name="register_with" value="email" checked class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="register_with_email" class="text-sm text-gray-500 ms-2 dark:text-gray-400">{{ __('Register with Email') }}</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" id="register_with_phone" name="register_with" value="phone" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="register_with_phone" class="text-sm text-gray-500 ms-2 dark:text-gray-400">{{ __('Register with Phone') }}</label>
                        </div>
                    </div>
                </div>

                <!-- Email Address -->
                <div id="email_field" class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div id="phone_field" class="mt-4" style="display: none;">
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>


                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const registerWithEmail = document.getElementById('register_with_email');
            const registerWithPhone = document.getElementById('register_with_phone');
            const emailField = document.getElementById('email_field');
            const phoneField = document.getElementById('phone_field');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone_number');

            function toggleFields() {
                if (registerWithEmail.checked) {
                    emailField.style.display = 'block';
                    phoneField.style.display = 'none';
                    emailInput.required = true;
                    phoneInput.required = false;
                } else {
                    emailField.style.display = 'none';
                    phoneField.style.display = 'block';
                    emailInput.required = false;
                    phoneInput.required = true;
                }
            }

            registerWithEmail.addEventListener('change', toggleFields);
            registerWithPhone.addEventListener('change', toggleFields);

            // Initial state
            toggleFields();
        });
    </script>
</x-auth-layout>
