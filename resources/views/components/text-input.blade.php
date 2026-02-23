@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-craft-500 focus:ring-craft-500 rounded-md shadow-sm']) }}>
