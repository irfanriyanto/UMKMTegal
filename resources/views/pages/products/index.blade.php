<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-craft-800 leading-tight">
            Katalog Produk
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:products.product-catalog />
        </div>
    </div>
</x-app-layout>
