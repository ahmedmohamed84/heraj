<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        <!-- Service Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- Select a Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dynamic Attributes Container -->
                        <div id="attributes-container" class="mb-4">
                            <!-- Attributes will be loaded here dynamically -->
                        </div>

                        <!-- Other service fields like description, price can be added here -->

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Create Service') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_id');
            const attributesContainer = document.getElementById('attributes-container');

            categorySelect.addEventListener('change', function () {
                const categoryId = this.value;
                attributesContainer.innerHTML = ''; // Clear previous attributes

                if (!categoryId) {
                    return;
                }

                // Use the new web route
                const url = `/categories/${categoryId}/attributes`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(attributes => {
                        if (attributes.length === 0) {
                            attributesContainer.innerHTML = '<p class="text-gray-500">No specific attributes for this category.</p>';
                            return;
                        }
                        
                        let html = '<h3 class="text-lg font-medium text-gray-900 mb-2">Category Attributes</h3>';
                        attributes.forEach(attribute => {
                            html += `
                                <div class="mb-3">
                                    <label for="attribute_${attribute.id}" class="block text-sm font-medium text-gray-700">${attribute.name}</label>
                                    <input type="text" name="attributes[${attribute.id}]" id="attribute_${attribute.id}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            `;
                        });
                        attributesContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching attributes:', error);
                        attributesContainer.innerHTML = '<p class="text-red-500">Could not load attributes.</p>';
                    });
            });
        });
    </script>
</x-app-layout>