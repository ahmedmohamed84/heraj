<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Page') }}: {{ $page->translation->title ?? 'New Page' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div x-data="{ activeTab: '{{ $languages->first()->code }}' }">
                        <!-- Tabs -->
                        <div class="p-6 border-b border-gray-200">
                            <nav class="flex flex-wrap -mb-px">
                                @foreach($languages as $language)
                                    <a href="#" @click.prevent="activeTab = '{{ $language->code }}'"
                                       :class="{ 'border-blue-500 text-blue-600': activeTab === '{{ $language->code }}' }"
                                       class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 mr-8">
                                        {{ $language->name }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>

                        <!-- Tab Content -->
                        <div class="p-6 bg-white">
                            @foreach($languages as $language)
                                @php
                                    // Get the translation for the current language, if it exists
                                    $translation = $page->translations->where('locale', $language->code)->first();
                                @endphp
                                <div x-show="activeTab === '{{ $language->code }}'">
                                    <div class="mb-4">
                                        <label for="title_{{ $language->code }}" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Title') }}</label>
                                        <input type="text" name="{{ $language->code }}[title]" id="title_{{ $language->code }}" value="{{ old($language->code . '.title', $translation->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="slug_{{ $language->code }}" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Slug') }}</label>
                                        <input type="text" name="{{ $language->code }}[slug]" id="slug_{{ $language->code }}" value="{{ old($language->code . '.slug', $translation->slug ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="content_{{ $language->code }}" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Content') }}</label>
                                        <textarea name="{{ $language->code }}[content]" id="content_{{ $language->code }}" rows="10" class="wysiwyg shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old($language->code . '.content', $translation->content ?? '') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Common fields -->
                    <div class="p-6 bg-gray-50 border-t border-gray-200">
                        <div class="mb-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" @if(old('is_published', $page->is_published)) checked @endif>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Published') }}</span>
                            </label>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Update Page') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Assuming you have a script that initializes a WYSIWYG editor on elements with the 'wysiwyg' class --}}
    {{-- For example, using TinyMCE:
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '.wysiwyg'
      });
    </script>
    --}}
    @endpush
</x-admin-layout>
