@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 dark:bg-gray-600 rounded-md transition-colors duration-150'
            : 'flex items-center px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-300 hover:text-white hover:bg-gray-700 dark:hover:bg-gray-600 rounded-md transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>