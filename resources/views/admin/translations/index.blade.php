<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Translations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Filters') }}</h3>
                    <form action="{{ route('admin.translations.index') }}" method="GET" class="flex items-center space-x-4">
                        <div>
                            <label for="locale" class="block text-sm font-medium text-gray-700">{{ __('Language') }}</label>
                            <select name="locale" id="locale" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                                @foreach($languages as $language)
                                    <option value="{{ $language->code }}" {{ $selectedLocale == $language->code ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="group" class="block text-sm font-medium text-gray-700">{{ __('Group') }}</label>
                            <select name="group" id="group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                                <option value="">{{ __('All Groups') }}</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group }}" {{ $selectedGroup == $group ? 'selected' : '' }}>{{ $group }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pt-5">
                             <a href="{{ route('admin.translations.index', ['locale' => $selectedLocale]) }}" class="text-sm text-gray-500 hover:text-gray-700">{{ __('Clear Group Filter') }}</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add New Translation Key -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Add New Translation') }}</h3>
                    <form action="{{ route('admin.translations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="locale" value="{{ $selectedLocale }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="group" class="block text-sm font-medium text-gray-700">{{ __('Group') }}</label>
                                <input type="text" name="group" id="group" value="{{ old('group', $selectedGroup) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('group') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="key" class="block text-sm font-medium text-gray-700">{{ __('Key') }}</label>
                                <input type="text" name="key" id="key" value="{{ old('key') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @error('key') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700">{{ __('Value') }}</label>
                                <input type="text" name="value" id="value" value="{{ old('value') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">{{ __('Add Translation') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Translations List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.translations.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="locale" value="{{ $selectedLocale }}">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ __('Edit Translations') }}</h3>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ __('Save All Changes') }}</button>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">{{ __('Group') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">{{ __('Key') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">{{ __('Value') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($translations as $translation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $translation->group }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $translation->key }}</td>
                                        <td class="px-6 py-4">
                                            <input type="text" name="translations[{{ $translation->id }}][value]" value="{{ $translation->value }}" class="block w-full rounded-md border-gray-300 shadow-sm">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">{{ __('No translations found for this language and group.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $translations->appends(request()->query())->links() }}
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ __('Save All Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
