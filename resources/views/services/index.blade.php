<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Your Services</h3>
                        <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Create New Service') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($services as $service)
                            <div class="border rounded-lg p-4 shadow-sm">
                                <h4 class="text-xl font-bold"><a href="{{ route('services.show', $service) }}">{{ $service->title }}</a></h4>
                                <p class="text-gray-600">{{ $service->category->name }}</p>
                                <p class="mt-2">{{ Str::limit($service->description, 100) }}</p>
                                <div class="mt-4 flex justify-end space-x-2">
                                    <a href="{{ route('services.edit', $service) }}" class="text-blue-500 hover:underline">{{ __('Edit') }}</a>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p>You have not created any services yet.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
