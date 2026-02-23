@php
    $hasProfile = auth()->user()->umkmProfile !== null;
@endphp

<div class="bg-white rounded-xl shadow-md p-4 mb-6">
    <nav class="flex flex-wrap gap-2">
        <a href="{{ route('umkm.dashboard') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('umkm.dashboard') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Dashboard
        </a>
        <a href="{{ route('umkm.profile') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('umkm.profile') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
            Profil Usaha
        </a>
        @if($hasProfile)
            <a href="{{ route('umkm.products') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('umkm.products') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
                Produk
            </a>
            <a href="{{ route('umkm.statistics') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('umkm.statistics') ? 'bg-craft-500 text-white' : 'bg-craft-100 text-craft-700 hover:bg-craft-200' }}">
                Statistik
            </a>
        @else
            <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" title="Lengkapi profil usaha terlebih dahulu">
                Produk
            </span>
            <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" title="Lengkapi profil usaha terlebih dahulu">
                Statistik
            </span>
        @endif
    </nav>
</div>
