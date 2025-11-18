<x-app-layout>
    <div dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <!-- Hero Section -->
        <div class="bg-white dark:bg-gray-800 shadow">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-12 text-center">
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        {{ __('Find The Perfect Service') }}
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {{ __('Discover services from talented people for your projects.') }}
                    </p>
                    <div class="mt-8 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        <div class="relative rounded-md shadow-sm w-full">
                            <input type="search" name="search" id="search" class="form-input block w-full pr-10 sm:text-sm sm:leading-5" placeholder="{{ __('Search for services...') }}">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        @if($categories->isNotEmpty())
        <div class="py-12 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white text-center mb-8">{{ __('Browse Categories') }}</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 text-center">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            {{-- Assuming you have an icon field or similar --}}
                            <div class="flex items-center justify-center h-16 w-16 bg-indigo-100 dark:bg-indigo-900 rounded-full mx-auto mb-4">
                                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm0 14h.01M7 17h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5a2 2 0 012-2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Latest Services Section -->
        @if($services->isNotEmpty())
        <div class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white text-center mb-8">{{ __('Latest Ads') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($services as $service)
                        <a href="{{ route('services.show', $service) }}" class="block group bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">{{ $service->title }}</h3>
                                <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">{{ $service->category->name }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($service->price) }} {{ __('EGP') }}</p>
                                    <div class="text-sm text-gray-500">
                                        <span>{{ $service->city->name ?? '' }}</span>
                                        <span class="mx-1">&middot;</span>
                                        <span>{{ $service->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>