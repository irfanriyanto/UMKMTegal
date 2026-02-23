@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center py-1 border-b-2 border-craft-500 text-sm font-medium leading-5 text-craft-800 focus:outline-none focus:border-craft-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center py-1 border-b-2 border-transparent text-sm font-medium leading-5 text-craft-600 hover:text-craft-800 hover:border-craft-300 focus:outline-none focus:text-craft-800 focus:border-craft-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
