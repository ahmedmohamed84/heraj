<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title') }}" required>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">{{ __('Category') }}</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">{{ __('Select a Category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city_id" class="block font-medium text-sm text-gray-700">{{ __('City') }}</label>
                                <select name="city_id" id="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">{{ __('Select a City') }}</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block font-medium text-sm text-gray-700">{{ __('Price') }}</label>
                                <input type="number" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('price') }}" required>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">{{ __('Contact Phone') }}</label>
                                <input type="text" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('phone') }}" required>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description') }}</textarea>
                            </div>

                            <!-- Main Image -->
                            <div class="md:col-span-2">
                                <label for="main_image" class="block font-medium text-sm text-gray-700">{{ __('Main Image') }}</label>
                                <input type="file" name="main_image" id="main_image" class="mt-1 block w-full" required>
                            </div>

                            <!-- Gallery Images -->
                            <div class="md:col-span-2">
                                <label for="gallery_images" class="block font-medium text-sm text-gray-700">{{ __('Gallery Images (optional)') }}</label>
                                <input type="file" name="gallery_images[]" id="gallery_images" class="mt-1 block w-full" multiple>
                            </div>

                            <!-- Dynamic Attributes Wrapper -->
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" id="attributes-wrapper">
                                <!-- Attributes will be loaded here -->
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create Service') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_id');
            const attributesWrapper = document.getElementById('attributes-wrapper');
            // Route for fetching attributes, defined in web.php
            const attributesUrl = '{{ route("categories.attributes", ["category" => ":id"]) }}';

            categorySelect.addEventListener('change', function () {
                const categoryId = this.value;
                attributesWrapper.innerHTML = ''; // Clear previous attributes

                if (!categoryId) {
                    return;
                }

                fetch(attributesUrl.replace(':id', categoryId))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(attributes => {
                        if (attributes.length === 0) {
                            attributesWrapper.innerHTML = `<p class="text-gray-500 md:col-span-2">{{ __('No specific attributes for this category.') }}</p>`;
                        } else {
                            attributes.forEach(attribute => {
                                const attributeContainer = document.createElement('div');
                                let attributeField = '';

                                const label = `<label for="attribute_${attribute.id}" class="block font-medium text-sm text-gray-700">${attribute.name}</label>`;

                                switch (attribute.type) {
                                    case 'text':
                                        attributeField = `<input type="text" name="attributes[${attribute.id}][value]" id="attribute_${attribute.id}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">`;
                                        break;
                                    case 'textarea':
                                        attributeField = `<textarea name="attributes[${attribute.id}][value]" id="attribute_${attribute.id}" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>`;
                                        break;
                                    case 'select':
                                        let optionsHtml = '<option value="">{{ __("Select an option") }}</option>';
                                        attribute.options.forEach(option => {
                                            optionsHtml += `<option value="${option.value}">${option.value}</option>`;
                                        });
                                        attributeField = `<select name="attributes[${attribute.id}][value]" id="attribute_${attribute.id}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">${optionsHtml}</select>`;
                                        break;
                                    case 'radio':
                                        attributeField = '<div class="mt-2 space-y-2">';
                                        attribute.options.forEach((option, index) => {
                                            attributeField += `
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="attributes[${attribute.id}][value]" value="${option.value}" class="form-radio">
                                                    <span class="ml-2">${option.value}</span>
                                                </label>`;
                                        });
                                        attributeField += '</div>';
                                        break;
                                    case 'checkbox':
                                         // For single checkbox, we can treat it as a boolean
                                        attributeField = `
                                            <label class="inline-flex items-center mt-2">
                                                <input type="hidden" name="attributes[${attribute.id}][value]" value="0">
                                                <input type="checkbox" name="attributes[${attribute.id}][value]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                                <span class="ml-2 text-sm text-gray-600">${attribute.name}</span>
                                            </label>`;
                                        // For checkbox group, logic would be different, assuming single for now.
                                        attributeContainer.innerHTML = attributeField; // No separate label for single checkbox
                                        attributesWrapper.appendChild(attributeContainer);
                                        return; // skip default label append
                                }

                                attributeContainer.innerHTML = label + attributeField;
                                attributesWrapper.appendChild(attributeContainer);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching attributes:', error);
                        attributesWrapper.innerHTML = `<p class="text-red-500 md:col-span-2">{{ __('Failed to load attributes.') }}</p>`;
                    });
            });
        });
    </script>
    @endpush
</x-app-layout>
