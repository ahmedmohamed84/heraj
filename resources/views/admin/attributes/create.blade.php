<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Attribute') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.attributes.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div class="mt-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onchange="toggleOptionsField()">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="select">Select</option>
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Options (for select, radio, checkbox) -->
                        <div class="mt-4" id="options-container" style="display: none;">
                            <x-input-label :value="__('Options')" />
                            <div id="options-wrapper" class="mt-2">
                                <!-- Option fields will be added here -->
                            </div>
                            <x-secondary-button type="button" id="add-option-button" class="mt-2">
                                {{ __('Add Option') }}
                            </x-secondary-button>
                            <x-input-error :messages="$errors->get('options')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Create Attribute') }}
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
            const optionsContainer = document.getElementById('options-container');
            if (type === 'select' || type === 'radio' || type === 'checkbox') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleOptionsField(); // Set initial state

            const addOptionButton = document.getElementById('add-option-button');
            const optionsWrapper = document.getElementById('options-wrapper');
            let optionIndex = 0;

            addOptionButton.addEventListener('click', function() {
                const optionInput = `
                    <div class="flex items-center mt-2" id="option-row-${optionIndex}">
                        <x-text-input class="block w-full" type="text" name="options[]" />
                        <x-danger-button type="button" class="ms-2 remove-option-button" data-index="${optionIndex}">
                            {{ __('Remove') }}
                        </x-danger-button>
                    </div>
                `;
                optionsWrapper.insertAdjacentHTML('beforeend', optionInput);
                optionIndex++;
            });

            optionsWrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-option-button')) {
                    const indexToRemove = e.target.getAttribute('data-index');
                    const rowToRemove = document.getElementById(`option-row-${indexToRemove}`);
                    if (rowToRemove) {
                        rowToRemove.remove();
                    }
                }
            });
        });
    </script>
</x-admin-layout>
