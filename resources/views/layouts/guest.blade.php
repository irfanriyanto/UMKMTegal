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
    </head>
    <body class="font-sans text-craft-900 antialiased">
        <!-- Background with blur effect -->
        <div class="min-h-screen relative">
            <!-- Background Image with Blur -->
            <div class="fixed inset-0 z-0">
                <img 
                    src="{{ asset('images/martabak.jpg') }}" 
                    alt="Background - Martabak" 
                    class="w-full h-full object-cover"
                >
                <div class="absolute inset-0 bg-craft-900/60 backdrop-blur-sm"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                <div class="mb-6">
                    <a href="/" class="flex items-center space-x-2">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                        </svg>
                        <span class="text-3xl font-extrabold">
                            <span class="text-craft-200">UMKM</span><span class="text-white">Tegal</span>
                        </span>
                    </a>
                </div>

                <div class="w-full sm:max-w-md px-6 py-8 bg-white/95 backdrop-blur shadow-2xl overflow-hidden sm:rounded-2xl border border-craft-200">
                    {{ $slot }}
                </div>
                
                <p class="mt-6 text-craft-200 text-sm">
                    &copy; {{ date('Y') }} UMKMTegal. Mendukung UMKM Kota Tegal.
                </p>
            </div>
        </div>
    </body>
</html>
