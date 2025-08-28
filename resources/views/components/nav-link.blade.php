@props(['active'])

@php
$classes = ($active ?? false)
            ? 'relative inline-flex items-center px-2 py-1 text-sm font-semibold text-yellow-400 after:content-[""] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-yellow-400 after:rounded-full'
            : 'relative inline-flex items-center px-2 py-1 text-sm font-medium text-white text-opacity-80 hover:text-yellow-300 hover:after:content-[""] hover:after:absolute hover:after:bottom-0 hover:after:left-0 hover:after:h-0.5 hover:after:w-full hover:after:bg-yellow-300 hover:after:rounded-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
