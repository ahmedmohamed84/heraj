<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                <p class="mt-2 text-gray-600">{{ __('Showing all ads in this category and its sub-categories.') }}</p>
            </div>

            @if($services->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($services as $service)
                        <a href="{{ route('services.show', $service) }}" class="block group bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                            <div class="relative">
                                <img src="{{ asset('storage/'. $service->image) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2 bg-blue-600 text-white text-sm font-bold px-2 py-1 rounded">
                                    {{ number_format($service->price, 0) }} {{ __('SAR') }}
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 truncate">{{ $service->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $service->city->name }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $service->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $services->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No Ads Found') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('There are currently no active ads in this category.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
