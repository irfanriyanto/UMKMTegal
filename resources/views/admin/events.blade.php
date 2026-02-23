<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-craft-800 leading-tight">
            Kelola Event
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-admin-nav />
            <livewire:admin.event-manager />
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    @endpush
</x-app-layout>
