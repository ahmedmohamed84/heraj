<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $service->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $service->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $service->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($service->category_id == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div id="attributes-wrapper" class="mt-4"></div>

                        <!-- User -->
                        <div class="mt-4">
                            <x-input-label for="user_id" :value="__('User')" />
                            <select id="user_id" name="user_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $service->user_id) == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <x-input-label for="city_id" :value="__('City')" />
                            <select id="city_id" name="city_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city_id', $service->city_id) == $city->id)>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="pending" @selected(old('status', $service->status) == 'pending')>Pending</option>
                                <option value="approved" @selected(old('status', $service->status) == 'approved')>Approved</option>
                                <option value="rejected" @selected(old('status', $service->status) == 'rejected')>Rejected</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Image')" />
                            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            @if ($service->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-20 h-20 object-cover">
                                </div>
                            @endif
                        </div>

                         <!-- Gallery Images -->
                        <div class="mt-4">
                            <x-input-label for="images" :value="__('Gallery Images')" />
                            <x-text-input id="images" class="block mt-1 w-full" type="file" name="images[]" multiple />
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            
                            <!-- Display existing gallery images -->
                            @if ($service->images->count() > 0)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Existing Gallery Images') }}</h3>
                                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                                        @foreach ($service->images as $image)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $service->title }}" class="w-20 h-20 object-cover">
                                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-md">
                                                    <a href="{{ asset('storage/' . $image->path) }}" target="_blank" class="text-white mr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <button type="button" data-image-id="{{ $image->id }}" class="text-white delete-image-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.services.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Back to list') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @php
    // Prepare the saved attributes for JavaScript
    // This creates a key-value pair of attribute_id => value
    $savedAttributes = $service->attributes->pluck('pivot.value', 'id');
    @endphp

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        const attributesWrapper = document.getElementById('attributes-wrapper');
        // Decode the saved attributes from PHP to a JavaScript object
        const savedAttributes = @json($savedAttributes);

        function fetchAndRenderAttributes(categoryId, prefillValues) {
            attributesWrapper.innerHTML = ''; // Clear previous attributes
            if (!categoryId) return;

            const url = '{{ route("categories.attributes", ["category" => ":id"]) }}'.replace(':id', categoryId);
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(attributes => {
                    if (attributes && attributes.length > 0) {
                        const title = document.createElement('h3');
                        title.className = 'text-lg font-medium text-gray-900 dark:text-gray-100';
                        title.innerText = '{{ __("Service Attributes") }}';
                        attributesWrapper.appendChild(title);
                    }

                    attributes.forEach(attribute => {
                        const attributeEl = document.createElement('div');
                        attributeEl.classList.add('mt-4');
                        const savedValue = prefillValues ? (savedAttributes[attribute.id] || null) : null;

                        let inputHtml = `<label for="attribute_${attribute.id}" class="block font-medium text-sm text-gray-700 dark:text-gray-300">${attribute.name}</label>`;

                        const type = attribute.type ? attribute.type.toLowerCase() : 'text';

                        switch (type) {
                            case 'number':
                                const numValue = savedValue !== null ? `value="${savedValue}"` : '';
                                inputHtml += `<input type="number" id="attribute_${attribute.id}" name="attributes[${attribute.id}]" ${numValue} class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">`;
                                break;

                            case 'select':
                                if (attribute.options && Array.isArray(attribute.options)) {
                                    inputHtml += `<select id="attribute_${attribute.id}" name="attributes[${attribute.id}]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">`;
                                    inputHtml += `<option value="">{{ __('Select an option') }}</option>`;
                                    attribute.options.forEach(option => {
                                        const isSelected = savedValue !== null && savedValue == option.value;
                                        const selectedAttr = isSelected ? 'selected' : '';
                                        inputHtml += `<option value="${option.value}" ${selectedAttr}>${option.value}</option>`;
                                    });
                                    inputHtml += `</select>`;
                                }
                                break;

                            case 'radio':
                                if (attribute.options && Array.isArray(attribute.options)) {
                                    inputHtml += '<div class="mt-2 space-y-2">';
                                    attribute.options.forEach((option, index) => {
                                        const optionId = `attribute_${attribute.id}_${index}`;
                                        const isChecked = savedValue !== null && savedValue == option.value;
                                        const checkedAttr = isChecked ? 'checked' : '';
                                        inputHtml += `
                                            <div class="flex items-center">
                                                <input type="radio" id="${optionId}" name="attributes[${attribute.id}]" value="${option.value}" ${checkedAttr} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                <label for="${optionId}" class="ms-3 block text-sm font-medium text-gray-700 dark:text-gray-300">${option.value}</label>
                                            </div>
                                        `;
                                    });
                                    inputHtml += '</div>';
                                }
                                break;
                            
                            case 'text':
                            default: // 'text' or any other type
                                const textValue = savedValue !== null ? `value="${savedValue}"` : '';
                                inputHtml += `<input type="text" id="attribute_${attribute.id}" name="attributes[${attribute.id}]" ${textValue} class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">`;
                                break;
                        }
                        attributeEl.innerHTML = inputHtml;
                        attributesWrapper.appendChild(attributeEl);
                    });
                })
                .catch(error => console.error('Error fetching attributes:', error));
        }

        // Load initial attributes for the current category on page load
        if (categorySelect.value) {
            fetchAndRenderAttributes(categorySelect.value, true);
        }

        // Add event listener for category change
        categorySelect.addEventListener('change', function() {
            // When category changes, don't prefill values
            fetchAndRenderAttributes(this.value, false);
        });

        // --- Preserve existing image deletion logic ---
        document.querySelectorAll('.delete-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.getAttribute('data-image-id');
                if (confirm('Are you sure you want to delete this image?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    // The route name should be admin.services.images.delete
                    form.action = '{{ route("admin.services.images.delete", ["image" => ":id"]) }}'.replace(':id', imageId);
                    form.style.display = 'none';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
    </script>
</x-admin-layout>
