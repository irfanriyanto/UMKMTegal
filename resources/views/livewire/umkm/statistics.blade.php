<div>
    @if(!$hasProfile)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Profil Usaha Belum Ada</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        Lengkapi profil usaha terlebih dahulu untuk melihat statistik.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('umkm.profile') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg">
                            Lengkapi Profil Usaha
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <p class="text-sm text-craft-500">Total Views Profil</p>
                <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['total_profile_views']) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <p class="text-sm text-craft-500">Views Profil Bulan Ini</p>
                <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['profile_views_month']) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <p class="text-sm text-craft-500">Total Views Produk</p>
                <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['total_product_views']) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <p class="text-sm text-craft-500">Views Produk Bulan Ini</p>
                <p class="text-2xl font-bold text-craft-800">{{ number_format($stats['product_views_month']) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Products -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-craft-800 mb-4">Produk Terpopuler</h3>
                @if($topProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $index => $product)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-6 h-6 bg-craft-100 rounded-full flex items-center justify-center text-sm font-medium text-craft-600 mr-3">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="text-sm font-medium text-craft-800">{{ $product->name }}</p>
                                        <p class="text-xs text-craft-500">{{ $product->category->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-craft-600">{{ $product->product_views_count }} views</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-craft-500 text-center py-4">Belum ada data views produk.</p>
                @endif
            </div>

            <!-- Recent Views Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-craft-800 mb-4">Views Profil 7 Hari Terakhir</h3>
                @if($recentViews->count() > 0)
                    <div class="space-y-2">
                        @php
                            $maxViews = $recentViews->max('count') ?: 1;
                        @endphp
                        @foreach($recentViews as $view)
                            <div class="flex items-center">
                                <span class="w-20 text-xs text-craft-500">{{ \Carbon\Carbon::parse($view->date)->format('d M') }}</span>
                                <div class="flex-1 mx-2">
                                    <div class="bg-craft-100 rounded-full h-4">
                                        <div class="bg-craft-500 rounded-full h-4" style="width: {{ ($view->count / $maxViews) * 100 }}%"></div>
                                    </div>
                                </div>
                                <span class="w-10 text-xs text-craft-600 text-right">{{ $view->count }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-craft-500 text-center py-4">Belum ada data views minggu ini.</p>
                @endif
            </div>
        </div>
    @endif
</div>
