<div>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-craft-800">Daftar Produk</h2>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="flex items-center gap-2">
            <div class="flex-1">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk atau UMKM..." 
                    class="w-full h-10 px-4 text-sm rounded-lg border border-gray-200 focus:border-craft-500 focus:ring-craft-500">
            </div>
            
            <!-- Filter Button -->
            <div x-data="{ 
                open: false,
                tempCategory: '{{ $categoryFilter }}',
                tempStatus: '{{ $statusFilter }}',
                initTemp() {
                    this.tempCategory = '{{ $categoryFilter }}';
                    this.tempStatus = '{{ $statusFilter }}';
                }
            }" class="relative">
                <button @click="open = !open; if(open) initTemp()" class="h-10 px-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-craft-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span class="text-sm text-craft-600">Filter</span>
                    @if($categoryFilter || $statusFilter)
                        <span class="w-1.5 h-1.5 bg-craft-500 rounded-full"></span>
                    @endif
                </button>
                
                <div x-show="open" x-transition @click.away="open = false"
                    class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-craft-200 p-4 z-50">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Kategori</label>
                            <select x-model="tempCategory" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Status</label>
                            <select x-model="tempStatus" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 text-sm">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2 border-t border-craft-100">
                            <button @click="open = false" class="flex-1 px-3 py-2 text-sm text-craft-600 hover:bg-craft-50 rounded-lg transition">
                                Batal
                            </button>
                            <button @click="$wire.set('categoryFilter', tempCategory); $wire.set('statusFilter', tempStatus); open = false" 
                                class="flex-1 px-3 py-2 text-sm bg-craft-500 text-white hover:bg-craft-600 rounded-lg transition">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($categoryFilter || $statusFilter)
                <button wire:click="$set('categoryFilter', ''); $set('statusFilter', '')" 
                    class="h-10 px-3 rounded-lg border border-red-200 hover:bg-red-50 transition text-red-500 flex items-center gap-1" title="Reset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-sm">Reset</span>
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-craft-200">
            <thead class="bg-craft-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">UMKM</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-craft-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm font-medium text-craft-900">{{ $product->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm text-craft-900">{{ $product->umkmProfile->business_name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-craft-600">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-craft-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_available ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm space-x-2">
                            <button wire:click="toggleAvailable({{ $product->id }})" class="{{ $product->is_available ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                {{ $product->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-craft-600 hover:text-craft-900">Lihat</a>
                            <button @click="$dispatch('show-confirm', {
                                title: 'Hapus Produk',
                                message: 'Yakin ingin menghapus produk ini?',
                                type: 'danger',
                                confirmText: 'Ya, Hapus',
                                onConfirm: () => $wire.delete({{ $product->id }})
                            })" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-craft-500">Tidak ada produk ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
