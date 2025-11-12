<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Setting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.settings.update', $setting) }}">
                        @csrf
                        @method('patch')

                        <!-- Key -->
                        <div>
                            <x-input-label for="key" :value="__('Key')" />
                            <x-text-input id="key" class="block mt-1 w-full" type="text" name="key" :value="old('key', $setting->key)" required autofocus />
                            <x-input-error :messages="$errors->get('key')" class="mt-2" />
                        </div>

                        <!-- Value -->
                        <div class="mt-4">
                            <x-input-label for="value" :value="__('Value')" />
                            <x-text-input id="value" class="block mt-1 w-full" type="text" name="value" :value="old('value', $setting->value)" />
                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
