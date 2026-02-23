<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts - Preconnect for faster loading -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Leaflet (OpenStreetMap) -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        
        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <!-- Global Loading Indicator -->
        <div wire:loading.delay class="fixed top-0 left-0 right-0 z-50">
            <div class="h-1 bg-craft-500 animate-pulse"></div>
        </div>
        
        <!-- Toast Notifications -->
        <x-toast-notification />
        
        <!-- Confirm Modal -->
        <x-confirm-modal />
        
        <div class="min-h-screen bg-craft-50">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow border-b border-craft-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
            <!-- Additional Scripts -->
            @stack('scripts')

            <!-- Footer -->
            <footer class="bg-craft-900 text-craft-100 mt-16">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-8 h-8 text-craft-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Icon Toko/Store -->
                                    <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                                </svg>
                                <h3 class="text-2xl font-extrabold">
                                    <span class="text-craft-300">UMKM</span><span class="text-white">Tegal</span>
                                </h3>
                            </div>
                            <p class="text-craft-200 font-semibold text-sm mb-3">Temukan, Dukung, Majukan.</p>
                            <p class="text-craft-400 text-sm mb-4">Platform digital untuk mendukung dan mempromosikan UMKM Indonesia.</p>
                            <!-- Hashtag Branding -->
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-craft-700 text-craft-200 px-3 py-1 rounded-full text-xs font-semibold">#UMKMTegal</span>
                                <span class="bg-craft-700 text-craft-200 px-3 py-1 rounded-full text-xs font-semibold">#SupportUMKMLokal</span>
                                <span class="bg-craft-700 text-craft-200 px-3 py-1 rounded-full text-xs font-semibold">#UMKMDigital</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-4">Navigasi</h4>
                            <ul class="space-y-2 text-sm text-craft-300">
                                <li><a href="{{ route('home') }}" class="hover:text-craft-100">Beranda</a></li>
                                <li><a href="{{ route('products.index') }}" class="hover:text-craft-100">Produk</a></li>
                                <li><a href="{{ route('umkm.index') }}" class="hover:text-craft-100">UMKM</a></li>
                                <li><a href="{{ route('articles.index') }}" class="hover:text-craft-100">Artikel</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-4">Bantuan</h4>
                            <ul class="space-y-2 text-sm text-craft-300">
                                <li><a href="{{ route('contact') }}" class="hover:text-craft-100">Hubungi Kami</a></li>
                                <li><a href="{{ route('about') }}" class="hover:text-craft-100">Tentang Kami</a></li>
                                <li><a href="{{ route('dukung-kami') }}" class="hover:text-craft-100">Dukung Kami</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-craft-700 mt-8 pt-8 text-center text-sm text-craft-400">
                        <p>&copy; {{ date('Y') }} <span class="text-craft-200">UMKM</span><span class="text-white">Tegal</span>. Mendukung UMKM Kota Tegal.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
