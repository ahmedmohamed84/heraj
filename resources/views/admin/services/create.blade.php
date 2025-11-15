<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <x-input-label for="city_id" :value="__('City')" />
                            <select id="city_id" name="city_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Image')" />
                            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Gallery Images -->
                        <div class="mt-4">
                            <x-input-label for="images" :value="__('Gallery Images')" />
                            <x-text-input id="images" class="block mt-1 w-full" type="file" name="images[]" multiple />
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.services.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Back to list') }}
                            </a>

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
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_id');
            const attributesWrapper = document.getElementById('attributes-wrapper');

            if (categorySelect) {
                categorySelect.addEventListener('change', function () {
                    const categoryId = this.value;
                    attributesWrapper.innerHTML = ''; // Clear previous attributes

                    if (categoryId) {
                        const url = '{{ route("categories.attributes", ["category" => ":id"]) }}'.replace(':id', categoryId);
                        fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
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

                                    let inputHtml = `<label for="attribute_${attribute.id}" class="block font-medium text-sm text-gray-700 dark:text-gray-300">${attribute.name}</label>`;

                                    switch (attribute.type) {
                                        case 'number':
                                            inputHtml += `<input type="number" id="attribute_${attribute.id}" name="attributes[${attribute.id}]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">`;
                                            break;

                                        case 'radio':
                                            if (attribute.options && Array.isArray(attribute.options)) {
                                                inputHtml += '<div class="mt-2 space-y-2">';
                                                attribute.options.forEach((option, index) => {
                                                    const optionId = `attribute_${attribute.id}_${index}`;
                                                    inputHtml += `
                                                        <div class="flex items-center">
                                                            <input type="radio" id="${optionId}" name="attributes[${attribute.id}]" value="${option}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                                            <label for="${optionId}" class="ms-3 block text-sm font-medium text-gray-700 dark:text-gray-300">${option}</label>
                                                        </div>
                                                    `;
                                                });
                                                inputHtml += '</div>';
                                            }
                                            break;

                                        default: // 'text' or any other type
                                            inputHtml += `<input type="text" id="attribute_${attribute.id}" name="attributes[${attribute.id}]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">`;
                                            break;
                                    }

                                    attributeEl.innerHTML = `<div>${inputHtml}</div>`;
                                    attributesWrapper.appendChild(attributeEl);
                                });
                            })
                            .catch(error => console.error('Error fetching attributes:', error));
                    }
                });
            }
        });
    </script>
</x-admin-layout>
