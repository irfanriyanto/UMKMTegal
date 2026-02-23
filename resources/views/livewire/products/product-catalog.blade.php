<div>
    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="flex items-center gap-2">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." 
                    class="w-full h-10 px-4 text-sm rounded-lg border border-gray-200 focus:border-craft-500 focus:ring-craft-500">
            </div>
            
            <!-- Filter Button with Dropdown -->
            <div x-data="{ 
                open: false,
                tempCategory: @entangle('categoryId'),
                tempMinPrice: @entangle('minPrice'),
                tempMaxPrice: @entangle('maxPrice'),
                tempSortBy: @entangle('sortBy'),
                tempSortOrder: @entangle('sortOrder'),
                initTemp() {
                    this.tempCategory = '{{ $categoryId }}';
                    this.tempMinPrice = '{{ $minPrice }}';
                    this.tempMaxPrice = '{{ $maxPrice }}';
                    this.tempSortBy = '{{ $sortBy }}';
                    this.tempSortOrder = '{{ $sortOrder }}';
                }
            }" x-init="initTemp()" class="relative">
                <button @click="open = !open; if(open) initTemp()" class="h-10 px-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-craft-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span class="text-sm text-craft-600">Filter</span>
                    @if($categoryId || $minPrice || $maxPrice || $sortBy !== 'created_at' || $sortOrder !== 'desc')
                        <span class="w-1.5 h-1.5 bg-craft-500 rounded-full"></span>
                    @endif
                </button>
                
                <!-- Dropdown Panel -->
                <div x-show="open" x-transition @click.away="open = false"
                    class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-craft-200 p-4 z-50">
                    <div class="space-y-4">
                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Kategori</label>
                            <select x-model="tempCategory" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Rentang Harga</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" x-model="tempMinPrice" placeholder="Min" 
                                    class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                <input type="number" x-model="tempMaxPrice" placeholder="Max" 
                                    class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                            </div>
                        </div>
                        
                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Urutkan</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select x-model="tempSortBy" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                    <option value="created_at">Terbaru</option>
                                    <option value="price">Harga</option>
                                    <option value="name">Nama</option>
                                </select>
                                <select x-model="tempSortOrder" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                    <option value="desc">Menurun</option>
                                    <option value="asc">Menaik</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2 border-t border-craft-100">
                            <button @click="open = false" class="flex-1 px-3 py-2 text-sm text-craft-600 hover:bg-craft-50 rounded-lg transition">
                                Batal
                            </button>
                            <button @click="$wire.set('categoryId', tempCategory); $wire.set('minPrice', tempMinPrice); $wire.set('maxPrice', tempMaxPrice); $wire.set('sortBy', tempSortBy); $wire.set('sortOrder', tempSortOrder); open = false" 
                                class="flex-1 px-3 py-2 text-sm bg-craft-500 text-white hover:bg-craft-600 rounded-lg transition">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reset Button (only show when filters applied) -->
            @if($categoryId || $minPrice || $maxPrice || $sortBy !== 'created_at' || $sortOrder !== 'desc')
                <button wire:click="clearFilters" class="h-10 px-3 rounded-lg border border-red-200 hover:bg-red-50 transition text-red-500 flex items-center gap-1" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-sm">Reset</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Products Grid -->
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
                    <p class="text-xs text-craft-400 mt-1">{{ $product->umkmProfile->business_name }}</p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-craft-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-craft-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p>Tidak ada produk ditemukan.</p>
                @if($search || $categoryId || $minPrice || $maxPrice)
                    <button wire:click="clearFilters" class="mt-4 text-craft-600 hover:text-craft-800 underline">
                        Reset filter
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
