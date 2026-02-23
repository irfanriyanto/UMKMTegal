<div>
    <!-- Search -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="flex items-center gap-2">
            <div class="flex-1">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari UMKM..." 
                    class="w-full h-10 px-4 text-sm rounded-lg border border-gray-200 focus:border-craft-500 focus:ring-craft-500">
            </div>
            
            <!-- Filter Button -->
            <div x-data="{ 
                open: false,
                tempSortBy: '{{ $sortBy }}',
                initTemp() {
                    this.tempSortBy = '{{ $sortBy }}';
                }
            }" class="relative">
                <button @click="open = !open; if(open) initTemp()" class="h-10 px-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-craft-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span class="text-sm text-craft-600">Filter</span>
                    @if($sortBy !== 'created_at')
                        <span class="w-1.5 h-1.5 bg-craft-500 rounded-full"></span>
                    @endif
                </button>
                
                <div x-show="open" x-transition @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-craft-200 p-4 z-50">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Urutkan</label>
                            <select x-model="tempSortBy" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                <option value="created_at">Terbaru</option>
                                <option value="business_name">Nama</option>
                            </select>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2 border-t border-craft-100">
                            <button @click="open = false" class="flex-1 px-3 py-2 text-sm text-craft-600 hover:bg-craft-50 rounded-lg transition">
                                Batal
                            </button>
                            <button @click="$wire.set('sortBy', tempSortBy); open = false" 
                                class="flex-1 px-3 py-2 text-sm bg-craft-500 text-white hover:bg-craft-600 rounded-lg transition">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($sortBy !== 'created_at')
                <button wire:click="clearFilters" class="h-10 px-3 rounded-lg border border-red-200 hover:bg-red-50 transition text-red-500 flex items-center gap-1" title="Reset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-sm">Reset</span>
                </button>
            @endif
        </div>
    </div>

    <!-- UMKM Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($umkmList as $umkm)
            <a href="{{ route('umkm.show', $umkm->slug) }}" class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-square bg-craft-100 relative overflow-hidden">
                    @if($umkm->primaryPhoto())
                        <img src="{{ Storage::url($umkm->primaryPhoto()->path) }}" alt="{{ $umkm->business_name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-craft-400">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                            </svg>
                        </div>
                    @endif
                    @if($umkm->is_verified)
                        <span class="absolute top-2 right-2 bg-craft-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Terverifikasi
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-craft-800 group-hover:text-craft-600 transition-colors">{{ $umkm->business_name }}</h3>
                    <p class="text-sm text-craft-500 mt-1 line-clamp-2">{{ Str::limit($umkm->description, 80) }}</p>
                    @if($umkm->address)
                        <p class="text-xs text-craft-400 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ Str::limit($umkm->address, 40) }}
                        </p>
                    @endif
                    <div class="mt-3 flex items-center gap-2 text-xs text-craft-400">
                        <span>{{ $umkm->products_count ?? $umkm->products()->count() }} Produk</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-craft-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-craft-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
                </svg>
                <p>Tidak ada UMKM ditemukan.</p>
                @if($search)
                    <button wire:click="clearFilters" class="mt-4 text-craft-600 hover:text-craft-800 underline">
                        Reset pencarian
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($umkmList->hasPages())
        <div class="mt-8">
            {{ $umkmList->links() }}
        </div>
    @endif
</div>
