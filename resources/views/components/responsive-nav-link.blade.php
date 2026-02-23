@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-craft-500 text-start text-base font-medium text-craft-700 bg-craft-50 focus:outline-none focus:text-craft-800 focus:bg-craft-100 focus:border-craft-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-craft-600 hover:text-craft-800 hover:bg-craft-50 hover:border-craft-300 focus:outline-none focus:text-craft-800 focus:bg-craft-50 focus:border-craft-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
