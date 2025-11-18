<x-app-layout>
    <div dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white text-center mb-8">{{ __('All Services') }}</h2>

                @if($services->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($services as $service)
                            <a href="{{ route('services.show', $service) }}" class="block group bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                                <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">{{ $service->title }}</h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">{{ $service->category->name }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($service->price) }} {{ __('SAR') }}</p>
                                        <div class="text-sm text-gray-500">
                                            <span>{{ $service->city->name ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $services->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-lg text-gray-500">{{ __('No services found.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
