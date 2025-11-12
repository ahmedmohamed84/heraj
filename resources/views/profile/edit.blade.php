<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div x-data="{ activeTab: 'profile' }" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8 px-4 sm:px-8" aria-label="Tabs">
                        <a href="#"
                           @click.prevent="activeTab = 'profile'"
                           :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'profile', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'profile' }"
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                        >
                            {{ __('Profile Information') }}
                        </a>
                        <a href="#"
                           @click.prevent="activeTab = 'password'"
                           :class="{ 'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'password', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'password' }"
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                        >
                            {{ __('Update Password') }}
                        </a>
                    </nav>
                </div>

                <div x-show="activeTab === 'profile'" class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div x-show="activeTab === 'password'" class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
