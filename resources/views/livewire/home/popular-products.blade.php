<div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-square bg-craft-100 relative overflow-hidden">
                    @if($product->primaryImage())
                        <img src="{{ Storage::url($product->primaryImage()->path) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-craft-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    @endif
                    @if($product->category)
                        <span class="absolute top-2 left-2 bg-craft-500/90 text-white text-xs px-2 py-1 rounded-full">
                            {{ $product->category->name }}
                        </span>
                    @endif
                </div>
                <div class="p-3 md:p-4">
                    <h3 class="font-medium text-craft-800 group-hover:text-craft-600 transition-colors text-sm md:text-base line-clamp-2">{{ $product->name }}</h3>
                    <p class="text-craft-600 font-semibold mt-1 text-sm md:text-base">{{ $product->formatted_price }}</p>
                    <p class="text-xs text-craft-400 mt-1">{{ $product->umkmProfile->business_name ?? '-' }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-craft-500">
                <p>Belum ada produk tersedia.</p>
            </div>
        @endforelse
    </div>

    @if($products->count() > 0)
        <div class="text-center mt-8">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-craft-600 hover:text-craft-800 font-medium">
                Lihat Semua Produk
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endif
</div>
