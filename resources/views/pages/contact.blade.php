<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-craft-800 leading-tight">
            Hubungi Kami
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <livewire:contact.contact-form />
                </div>
                <div>
                    <livewire:contact.faq-section />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
