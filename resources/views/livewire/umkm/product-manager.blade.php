<div>
    @if(!$hasProfile)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Profil Usaha Belum Ada</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        Anda harus melengkapi profil usaha terlebih dahulu sebelum bisa menambahkan produk.
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
        @if(!$showForm)
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-craft-800">Daftar Produk</h2>
                    <p class="text-sm text-craft-500">{{ $productCount }}/{{ $maxProducts }} produk</p>
                </div>
                @if($canAddMore)
                    <button wire:click="create" class="bg-craft-500 hover:bg-craft-600 text-white px-4 py-2 rounded-lg">
                        + Tambah Produk
                    </button>
                @else
                    <span class="text-sm text-amber-600 bg-amber-50 px-4 py-2 rounded-lg">
                        Batas maksimal {{ $maxProducts }} produk tercapai
                    </span>
                @endif
            </div>

            @if($products->count() > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <table class="min-w-full divide-y divide-craft-200">
                        <thead class="bg-craft-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Produk</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-craft-200">
                            @foreach($products as $product)
                                <tr>
                                    <td class="px-6 py-4 text-center">
                                        <div class="text-sm font-medium text-craft-900">{{ $product->name }}</div>
                                        <div class="text-sm text-craft-500">{{ Str::limit($product->description, 40) }}</div>
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
                                            {{ $product->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm space-x-2">
                                        <button wire:click="edit({{ $product->id }})" class="text-craft-600 hover:text-craft-900">Edit</button>
                                        <button wire:click="toggleAvailable({{ $product->id }})" class="{{ $product->is_available ? 'text-yellow-600' : 'text-green-600' }}">
                                            {{ $product->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                        <button @click="$dispatch('show-confirm', {
                                            title: 'Hapus Produk',
                                            message: 'Yakin ingin menghapus produk ini?',
                                            type: 'danger',
                                            confirmText: 'Ya, Hapus',
                                            onConfirm: () => $wire.delete({{ $product->id }})
                                        })" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="text-lg font-semibold text-craft-800 mb-2">Belum Ada Produk</h3>
                    <p class="text-craft-600 mb-4">Mulai tambahkan produk Anda untuk ditampilkan ke pengunjung.</p>
                    <button wire:click="create" class="bg-craft-500 hover:bg-craft-600 text-white px-6 py-2 rounded-lg">
                        + Tambah Produk Pertama
                    </button>
                </div>
            @endif
        @else
            <!-- Product Form -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-craft-800 mb-6">{{ $isEditing ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>
                
                <form wire:submit="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Nama Produk *</label>
                            <input type="text" wire:model="name" 
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="Contoh: Batik Tulis Motif Parang">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Kategori *</label>
                            <select wire:model="category_id" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-700 mb-1">Deskripsi Produk *</label>
                        <textarea wire:model="description" rows="4"
                            class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                            placeholder="Jelaskan detail produk, bahan, ukuran, dll..."></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Harga (Rp) *</label>
                            <input type="number" wire:model="price" min="0"
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="150000">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Status</label>
                            <label class="flex items-center mt-2">
                                <input type="checkbox" wire:model="is_available" class="rounded border-craft-300 text-craft-500 focus:ring-craft-500">
                                <span class="ml-2 text-sm text-craft-700">Produk tersedia</span>
                            </label>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-medium text-craft-700 mb-1">Foto Produk *</label>
                        
                        @if(count($existingImages) > 0)
                            <div class="flex flex-wrap gap-4 mb-4">
                                @foreach($existingImages as $image)
                                    <div class="relative">
                                        <img src="{{ Storage::url($image['path']) }}" alt="Foto produk" class="w-24 h-24 object-cover rounded-lg">
                                        <button type="button" wire:click="deleteImage({{ $image['id'] }})" 
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                            ✕
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(count($existingImages) == 0)
                            <input type="file" wire:model="photo" accept=".jpg,.jpeg,.png"
                                class="w-full text-sm text-craft-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-craft-100 file:text-craft-700 hover:file:bg-craft-200">
                            <p class="text-xs text-craft-500 mt-1">Upload maksimal 1 foto dengan ukuran maksimal 2MB. Format: JPG, JPEG atau PNG.</p>
                            <p class="text-xs text-amber-600 mt-1">Upload foto dengan rasio 1:1, foto dengan rasio portrait atau landscape akan terpotong otomatis menjadi rasio 1:1.</p>
                        @else
                            <p class="text-xs text-amber-600">Hapus foto yang ada untuk mengganti dengan foto baru.</p>
                        @endif
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        
                        @if($photo)
                            <div class="mt-2">
                                <p class="text-sm text-craft-600">Preview:</p>
                                <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mt-1">
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="bg-craft-500 hover:bg-craft-600 text-white px-6 py-2 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" wire:loading.attr="disabled">
                            <svg wire:loading wire:target="save" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Simpan Perubahan' : 'Tambah Produk' }}</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                        <button type="button" wire:click="cancel" class="bg-craft-100 hover:bg-craft-200 text-craft-700 font-medium px-6 py-2 rounded-lg transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endif
</div>
