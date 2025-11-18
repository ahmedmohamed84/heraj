<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                    <!-- Main Image -->
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-auto object-cover rounded-lg shadow-lg">
                    </div>

                    <!-- Gallery Images -->
                    @if($service->gallery->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Gallery') }}</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach($service->gallery as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Gallery image" class="w-full h-32 object-cover rounded-md shadow-sm">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- Service Title -->
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $service->title }}</h1>
                    <!-- Price -->
                    <p class="text-3xl font-bold text-blue-600 mb-4">{{ number_format($service->price, 2) }} {{ __('EGP') }}</p>

                    <!-- Description -->
                    <div class="prose max-w-none text-gray-700 mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('Description') }}</h3>
                        <p>{!! nl2br(e($service->description)) !!}</p>
                    </div>

                    <!-- Attributes -->
                    @if($service->attributes->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Details') }}</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-md">
                                @foreach($service->attributes as $attribute)
                                    <div class="flex justify-between border-b pb-2">
                                        <span class="font-semibold text-gray-600">{{ $attribute->name }}:</span>
                                        <span class="text-gray-800 font-medium">{{ $attribute->pivot->value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="md:col-span-1 space-y-6">
                    <!-- User Info -->
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('Seller Information') }}</h3>
                        <p class="text-lg text-gray-700 font-semibold">{{ $service->user->name }}</p>
                        <p class="text-gray-500">{{ __('Member since') }} {{ $service->user->created_at->format('M Y') }}</p>
                        <div class="mt-4">
                            <a href="tel:{{ $service->phone }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white font-bold rounded-md hover:bg-green-600 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $service->phone }}
                            </a>
                        </div>
                        @auth
                            @if(Auth::id() !== $service->user_id)
                                <div class="mt-2">
                                    <form action="{{ route('conversations.start') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 transition">
                                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                                            </svg>
                                            {{ __('Start Chat') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Location Info -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">{{ __('Location') }}</h3>
                        <p class="text-gray-700"><span class="font-semibold">{{ __('City') }}:</span> {{ $service->city->name }}</p>
                        <p class="text-gray-700"><span class="font-semibold">{{ __('Category') }}:</span> {{ $service->category->name }}</p>
                        <p class="text-gray-500 mt-2 text-sm">{{ __('Posted') }} {{ $service->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Related Services -->
                    @if($relatedServices->count() > 0)
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('Related Ads') }}</h3>
                            <div class="space-y-4">
                                @foreach($relatedServices as $related)
                                    <a href="{{ route('services.show', $related) }}" class="block group">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-20 h-20 object-cover rounded-md shadow-sm">
                                            <div>
                                                <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition">{{ $related->title }}</h4>
                                                <p class="text-blue-500 font-bold">{{ number_format($related->price, 2) }} {{ __('SAR') }}</p>
                                                <p class="text-sm text-gray-500">{{ $related->city->name }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
