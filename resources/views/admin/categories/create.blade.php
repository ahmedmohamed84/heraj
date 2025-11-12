<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Parent Category -->
                        <div class="mt-4">
                            <x-input-label for="parent_id" :value="__('Parent Category')" />
                            <select id="parent_id" name="parent_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">No Parent</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                        </div>

                        <!-- Attributes Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Category Attributes</h3>
                            <div id="attributes-container" class="mt-4 space-y-4">
                                @foreach ($attributes as $attribute)
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="attributes[{{ $attribute->id }}][id]" value="{{ $attribute->id }}"
                                               id="attribute_{{ $attribute->id }}"
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               onchange="toggleAttributeValueField(this, 'attribute_value_{{ $attribute->id }}')">
                                        <x-input-label for="attribute_{{ $attribute->id }}" :value="$attribute->name" />

                                        <div id="attribute_value_{{ $attribute->id }}" style="display: none;">
                                            @if ($attribute->type === 'text')
                                                <x-text-input type="text" name="attributes[{{ $attribute->id }}][value]" class="ml-2" placeholder="Enter value" />
                                            @elseif ($attribute->type === 'number')
                                                <x-text-input type="number" name="attributes[{{ $attribute->id }}][value]" class="ml-2" placeholder="Enter number" />
                                            @elseif ($attribute->type === 'select' && $attribute->options)
                                                <select name="attributes[{{ $attribute->id }}][value]" class="ml-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option value="">Select an option</option>
                                                    @foreach (json_decode($attribute->options) as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif ($attribute->type === 'radio' && $attribute->options)
                                                <div class="ml-2 flex space-x-2">
                                                    @foreach (json_decode($attribute->options) as $option)
                                                        <input type="radio" name="attributes[{{ $attribute->id }}][value]" value="{{ $option }}" id="attribute_{{ $attribute->id }}_radio_{{ $loop->index }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                        <label for="attribute_{{ $attribute->id }}_radio_{{ $loop->index }}">{{ $option }}</label>
                                                    @endforeach
                                                </div>
                                            @elseif ($attribute->type === 'checkbox' && $attribute->options)
                                                <div class="ml-2 flex space-x-2">
                                                    @foreach (json_decode($attribute->options) as $option)
                                                        <input type="checkbox" name="attributes[{{ $attribute->id }}][value][]" value="{{ $option }}" id="attribute_{{ $attribute->id }}_checkbox_{{ $loop->index }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                        <label for="attribute_{{ $attribute->id }}_checkbox_{{ $loop->index }}">{{ $option }}</label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAttributeValueField(checkbox, valueFieldId) {
            const valueField = document.getElementById(valueFieldId);
            if (checkbox.checked) {
                valueField.style.display = 'block';
            } else {
                valueField.style.display = 'none';
                // Optionally clear the value when unchecked
                const input = valueField.querySelector('input, select');
                if (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#attributes-container input[type="checkbox"]').forEach(checkbox => {
                const valueFieldId = 'attribute_value_' + checkbox.id.split('_')[1];
                toggleAttributeValueField(checkbox, valueFieldId);
            });
        });
    </script>
</x-admin-layout>
