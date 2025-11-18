<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">{{ __('My Conversations') }}</h1>

                    <div class="space-y-4">
                        @forelse ($conversations as $conversation)
                            <a href="{{ route('conversations.show', $conversation) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $conversation->service->image) }}" alt="{{ $conversation->service->title }}">
                                        </div>
                                        <div>
                                            <p class="font-bold text-lg text-gray-800">
                                                {{ $conversation->service->title }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                @if ($conversation->buyer_id == Auth::id())
                                                    {{ __('With') }}: {{ $conversation->seller->name }}
                                                @else
                                                    {{ __('With') }}: {{ $conversation->buyer->name }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($conversation->messages->isNotEmpty())
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $conversation->messages->first()->body }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $conversation->messages->first()->created_at->diffForHumans() }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p>{{ __('You have no conversations yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
