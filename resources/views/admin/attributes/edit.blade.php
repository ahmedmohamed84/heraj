<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Attribute') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.attributes.update', $attribute->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $attribute->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div class="mt-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onchange="toggleOptionsField()">
                                <option value="text" {{ $attribute->type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="number" {{ $attribute->type == 'number' ? 'selected' : '' }}>Number</option>
                                <option value="select" {{ $attribute->type == 'select' ? 'selected' : '' }}>Select</option>
                                <option value="radio" {{ $attribute->type == 'radio' ? 'selected' : '' }}>Radio</option>
                                <option value="checkbox" {{ $attribute->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Options (for select, radio, checkbox) -->
                        <div class="mt-4" id="options-field" style="display: none;">
                            <x-input-label for="options" :value="__('Options (comma-separated)')" />
                            <x-text-input id="options" class="block mt-1 w-full" type="text" name="options" :value="old('options', $attribute->options ? implode(', ', json_decode($attribute->options)) : '')" />
                            <x-input-error :messages="$errors->get('options')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Enter options separated by commas (e.g., Option1, Option2, Option3)</p>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update Attribute') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOptionsField() {
            const type = document.getElementById('type').value;
            const optionsField = document.getElementById('options-field');
            if (type === 'select' || type === 'radio' || type === 'checkbox') {
                optionsField.style.display = 'block';
            } else {
                optionsField.style.display = 'none';
            }
        }
        // Call on page load to set initial state
        document.addEventListener('DOMContentLoaded', toggleOptionsField);
    </script>
</x-admin-layout>
