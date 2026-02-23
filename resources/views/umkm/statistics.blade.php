<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-craft-800 leading-tight">
            Statistik
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-umkm-nav />
            <livewire:umkm.statistics />
        </div>
    </div>
</x-app-layout>
