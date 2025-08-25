@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link-hover inline-flex items-center px-1 pt-1 border-b-2 border-yellow-400 text-sm font-medium leading-5 text-white focus:outline-none focus:border-yellow-300 transition duration-150 ease-in-out'
            : 'nav-link-hover inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white text-opacity-80 hover:text-white hover:border-yellow-300 focus:outline-none focus:text-white focus:border-yellow-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
