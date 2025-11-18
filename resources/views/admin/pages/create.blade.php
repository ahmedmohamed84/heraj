<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ __('Whoops! Something went wrong.') }}</strong>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.pages.store') }}" method="POST">
                        @csrf

                        {{-- Tab Navigation --}}
                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px" id="myTabs" role="tablist">
                                @foreach($languages as $lang)
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300"
                                            id="{{ $lang->code }}-tab"
                                            data-tabs-target="#{{ $lang->code }}"
                                            type="button"
                                            role="tab"
                                            aria-controls="{{ $lang->code }}"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $lang->name }}
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Tab Content --}}
                        <div id="myTabsContent">
                            @foreach($languages as $lang)
                            <div class="hidden p-4 bg-gray-50 rounded-lg" id="{{ $lang->code }}" role="tabpanel" aria-labelledby="{{ $lang->code }}-tab">
                                <div class="mb-4">
                                    <label for="{{ $lang->code }}_title" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Title') }} ({{ strtoupper($lang->code) }})</label>
                                    <input type="text" name="{{ $lang->code }}[title]" id="{{ $lang->code }}_title" value="{{ old($lang->code.'.title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="mb-4">
                                    <label for="{{ $lang->code }}_slug" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Slug') }} ({{ strtoupper($lang->code) }})</label>
                                    <input type="text" name="{{ $lang->code }}[slug]" id="{{ $lang->code }}_slug" value="{{ old($lang->code.'.slug') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="mb-4">
                                    <label for="{{ $lang->code }}_content" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Content') }} ({{ strtoupper($lang->code) }})</label>
                                    <textarea name="{{ $lang->code }}[content]" id="{{ $lang->code }}_content" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old($lang->code.'.content') }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-6">

                        {{-- Common Fields --}}
                        <div class="mb-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_published') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Published') }}</span>
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Basic tab switching logic
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');

            // Show the first tab by default
            const firstTab = document.querySelector('[aria-selected="true"]');
            if(firstTab) {
                const target = document.querySelector(firstTab.dataset.tabsTarget);
                target.classList.remove('hidden');
            }


            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // De-select all tabs
                    tabs.forEach(t => {
                        t.setAttribute('aria-selected', 'false');
                        t.classList.remove('text-gray-900', 'border-gray-900');
                        t.classList.add('text-gray-500', 'border-transparent');
                    });

                    // Show the clicked tab's content
                    const target = document.querySelector(this.dataset.tabsTarget);
                    target.classList.remove('hidden');

                    // Select the clicked tab
                    this.setAttribute('aria-selected', 'true');
                    this.classList.add('text-gray-900', 'border-gray-900');
                    this.classList.remove('text-gray-500', 'border-transparent');
                });
            });
        });
    </script>
</x-admin-layout>
