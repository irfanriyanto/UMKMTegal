<div>
    @if($product)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- Product Image - Fixed 1:1 ratio --}}
            <div class="flex justify-center py-6 bg-craft-50" style="box-shadow: inset 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                @if($product->images->count() > 0)
                    <div class="overflow-hidden rounded-lg shadow-md flex-shrink-0" style="width: 320px; height: 320px;">
                        <img src="{{ Storage::url($product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="bg-gradient-to-br from-craft-400 to-kayu-500 flex items-center justify-center text-white rounded-lg flex-shrink-0" style="width: 320px; height: 320px;">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-8">
                    @if($product->category)
                        <span class="text-sm text-craft-500">{{ $product->category->name }}</span>
                    @endif
                    <h1 class="text-2xl font-bold text-craft-800 mt-2">{{ $product->name }}</h1>
                    <p class="text-3xl font-bold text-craft-600 mt-4">{{ $product->formatted_price }}</p>
                    <div class="mt-6 prose prose-craft">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    <div class="mt-8 p-4 bg-craft-50 rounded-lg">
                        <h3 class="font-semibold text-craft-800">Penjual</h3>
                        <a href="{{ route('umkm.show', $product->umkmProfile->slug) }}" class="text-craft-600 hover:text-craft-800">
                            {{ $product->umkmProfile->business_name }}
                        </a>
                        @if($product->umkmProfile->phone)
                            <p class="text-sm text-craft-500 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $product->umkmProfile->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-craft-500">Produk tidak ditemukan.</p>
            <a href="{{ route('products.index') }}" class="text-craft-600 hover:underline mt-4 inline-block">Kembali ke katalog</a>
        </div>
    @endif
</div>
