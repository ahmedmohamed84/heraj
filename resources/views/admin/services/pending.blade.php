<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pending Services Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Title') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('User') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Category') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('City') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Submitted At') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">{{ __('Actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('admin.services.show', $service) }}" class="hover:underline" target="_blank">{{ $service->title }}</a>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $service->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $service->category->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $service->city->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $service->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline">{{ __('Approve') }}</button>
                                        </form>
                                        <a href="{{ route('admin.services.edit', $service) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-2">{{ __('Edit') }}</a>
                                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure you want to reject and delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Reject') }}</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('No pending services found.') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
