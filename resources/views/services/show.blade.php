<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $service->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold text-gray-900">{{ $service->title }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Posted in <a href="#" class="text-indigo-600 hover:underline">{{ $service->category->name }}</a> by {{ $service->user->name }}
                    </p>

                    {{-- Add other service details here, like description, price, etc. --}}
                    {{-- <p class="mt-4 text-gray-800">{{ $service->description }}</p> --}}
                    {{-- <p class="mt-4 text-2xl font-bold text-gray-900">${{ number_format($service->price, 2) }}</p> --}}

                    @if($service->attributes->count() > 0)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-lg font-medium text-gray-900">Specifications</h4>
                            <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                @foreach($service->attributes as $attribute)
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ $attribute->name }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attribute->pivot->value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>