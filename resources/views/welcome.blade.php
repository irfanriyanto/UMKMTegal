<x-app-layout>
    <!-- Hero Section -->
    <section class="relative text-white overflow-hidden min-h-[600px]">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img 
                src="{{ asset('images/martabak.jpg') }}" 
                alt="Jajanan Tradisional Indonesia - Martabak" 
                class="w-full h-full object-cover"
            >
            <!-- Dark Overlay untuk keterbacaan teks -->
            <div class="absolute inset-0 bg-gradient-to-br from-craft-900/85 via-craft-800/80 to-kayu-900/85"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
            <div class="text-center">
                <!-- App Name - Highlighted -->
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold mb-4 tracking-tight">
                    <span class="bg-gradient-to-r from-craft-200 via-craft-100 to-craft-200 bg-clip-text text-transparent drop-shadow-lg">UMKM</span><span class="text-white drop-shadow-lg">Pedia</span>
                </h1>
                <!-- Tagline - Highlighted -->
                <p class="text-2xl md:text-3xl lg:text-4xl font-bold mb-8 tracking-wide">
                    <span class="bg-gradient-to-r from-craft-100 via-craft-200 to-craft-100 bg-clip-text text-transparent">Temukan, Dukung, Majukan.</span>
                </p>
                <p class="text-lg md:text-xl text-craft-200 mb-4 max-w-3xl mx-auto leading-relaxed">
                    Platform digital untuk menemukan dan mendukung produk-produk berkualitas dari Usaha Mikro, Kecil, dan Menengah di <span class="font-bold text-white">Indonesia</span>.
                </p>
                <p class="text-base md:text-lg text-craft-300 mb-6 max-w-2xl mx-auto">
                    Mendukung kemajuan UMKM Indonesia menuju pasar yang lebih luas.
                </p>
                <!-- Hashtag Branding -->
                <div class="flex flex-wrap justify-center gap-3 mb-8">
                    <span class="bg-white/20 backdrop-blur text-white px-4 py-2 rounded-full text-sm font-bold border border-white/30 hover:bg-white/30 transition cursor-default">#UMKMTegal</span>
                    <span class="bg-white/20 backdrop-blur text-white px-4 py-2 rounded-full text-sm font-bold border border-white/30 hover:bg-white/30 transition cursor-default">#SupportUMKMLokal</span>
                    <span class="bg-white/20 backdrop-blur text-white px-4 py-2 rounded-full text-sm font-bold border border-white/30 hover:bg-white/30 transition cursor-default">#UMKMDigital</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products.index') }}" class="bg-craft-100 hover:bg-craft-50 text-craft-800 font-bold px-8 py-3 rounded-xl transition shadow-xl hover:shadow-2xl text-lg">
                        Jelajahi Produk
                    </a>
                    <a href="{{ route('umkm.index') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur text-white font-bold px-8 py-3 rounded-xl transition border-2 border-white/40 hover:border-white/60 text-lg">
                        Temukan UMKM
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured UMKM Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-craft-800 mb-4">UMKM Pilihan Tegal</h2>
                <p class="text-craft-600">Temukan usaha lokal terbaik dari seluruh Indonesia</p>
            </div>
            <livewire:home.featured-umkm />
        </div>
    </section>

    <!-- Popular Products Section -->
    <section class="py-16 bg-craft-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-craft-800 mb-4">Produk Populer Tegal</h2>
                <p class="text-craft-600">Produk-produk UMKM Tegal yang paling diminati</p>
            </div>
            <livewire:home.popular-products />
        </div>
    </section>

    <!-- Latest Articles Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-craft-800 mb-4">Artikel Terbaru</h2>
                <p class="text-craft-600">Tips dan informasi seputar UMKM</p>
            </div>
            <livewire:home.latest-articles />
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="py-16 bg-gradient-to-br from-tanah-100 to-craft-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-craft-800 mb-4">Event Mendatang</h2>
                <p class="text-craft-600">Jangan lewatkan event-event menarik untuk UMKM</p>
            </div>
            <livewire:home.upcoming-events />
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-craft-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Punya UMKM di Tegal? Bergabunglah Bersama Kami!</h2>
            <p class="text-craft-200 mb-6 max-w-3xl mx-auto">Daftarkan usaha Anda dan jangkau lebih banyak pelanggan di seluruh Indonesia. Gratis dan mudah!</p>
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                <span class="text-craft-300 font-semibold">#UMKMTegal</span>   
                <span class="text-craft-300 font-semibold">#SupportUMKMLokal</span>
                <span class="text-craft-300 font-semibold">#UMKMDigital</span>
            </div>
            <a href="{{ route('register') }}" class="inline-block bg-craft-100 hover:bg-craft-50 text-craft-800 font-semibold px-8 py-3 rounded-lg transition shadow-lg">
                Daftar Sekarang
            </a>
        </div>
    </section>
</x-app-layout>
