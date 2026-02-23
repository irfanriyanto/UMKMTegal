<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 p-3 rounded-full bg-craft-100 text-craft-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-craft-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-xs text-transparent select-none">-</p>
                </div>
            </div>
        </div>

        <!-- Total UMKM -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 p-3 rounded-full bg-craft-100 text-craft-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-craft-500">Total UMKM</p>
                    <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['total_umkm']) }}</p>
                    <p class="text-xs text-green-600">{{ $stats['verified_umkm'] }} terverifikasi</p>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 p-3 rounded-full bg-craft-100 text-craft-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-craft-500">Total Produk</p>
                    <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-xs text-transparent select-none">-</p>
                </div>
            </div>
        </div>

        <!-- Unread Messages -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 p-3 rounded-full bg-craft-100 text-craft-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-craft-500">Pesan Belum Dibaca</p>
                    <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['unread_messages']) }}</p>
                    <p class="text-xs text-transparent select-none">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="font-semibold text-craft-800 mb-4">Artikel</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-craft-500">Total</span>
                    <span class="font-medium">{{ $stats['total_articles'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-craft-500">Dipublikasi</span>
                    <span class="font-medium text-green-600">{{ $stats['published_articles'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="font-semibold text-craft-800 mb-4">Event</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-craft-500">Total</span>
                    <span class="font-medium">{{ $stats['total_events'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-craft-500">Aktif</span>
                    <span class="font-medium text-green-600">{{ $stats['active_events'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="font-semibold text-craft-800 mb-4">Views Hari Ini</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-craft-500">Profil UMKM</span>
                    <span class="font-medium">{{ $stats['profile_views_today'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-craft-500">Produk</span>
                    <span class="font-medium">{{ $stats['product_views_today'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
