<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Setting Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <x-input-label for="key" :value="__('Key')" />
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $setting->key }}</p>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="value" :value="__('Value')" />
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $setting->value }}</p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.settings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Back to Settings') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
