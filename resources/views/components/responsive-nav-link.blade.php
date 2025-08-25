@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-400 text-start text-base font-medium text-white bg-red-800 focus:outline-none focus:text-yellow-200 focus:bg-red-900 focus:border-yellow-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white text-opacity-80 hover:text-white hover:bg-red-800 hover:border-yellow-300 focus:outline-none focus:text-white focus:bg-red-800 focus:border-yellow-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
