<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cities Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Cities List') }}</h3>
                        <a href="{{ route('admin.cities.create') }}" class="px-4 py-2 bg-green-500 text-black rounded-md hover:bg-green-600">{{ __('Add New City') }}</a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Region') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Created Date') }}</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">تعديل</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($cities as $city)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $city->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $city->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $city->region->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $city->created_at->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.cities.edit', $city) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">{{ __('Edit') }}</a>
                                            <form action="{{ route('admin.cities.destroy', $city) }}" method="POST" class="inline-block mr-2" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذه المدينة؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">{{ __('There is Nothing to show') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $cities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
