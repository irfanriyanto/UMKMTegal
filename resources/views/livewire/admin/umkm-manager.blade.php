<div>
    @if($showAddForm)
        {{-- Form Tambah UMKM Baru --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-craft-800">Daftarkan UMKM Baru</h2>
                    <p class="text-sm text-craft-500">Untuk UMKM yang tidak memiliki email atau kesulitan mendaftar sendiri</p>
                </div>
                <button wire:click="closeAddForm" class="text-craft-500 hover:text-craft-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit="createUmkm" class="space-y-6">
                {{-- Data Pemilik --}}
                <div class="border-b border-craft-200 pb-4">
                    <h3 class="text-lg font-medium text-craft-700 mb-4">Data Pemilik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Nama Pemilik <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="ownerName" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500" placeholder="Nama lengkap pemilik">
                            @error('ownerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">No. HP Pemilik <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="ownerPhone" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500" placeholder="08xxxxxxxxxx">
                            @error('ownerPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Data Usaha --}}
                <div class="border-b border-craft-200 pb-4">
                    <h3 class="text-lg font-medium text-craft-700 mb-4">Data Usaha</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Nama Usaha <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="businessName" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500" placeholder="Nama toko/usaha">
                            @error('businessName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Deskripsi Usaha</label>
                            <textarea wire:model="businessDescription" rows="3" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500" placeholder="Deskripsi singkat tentang usaha"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">Alamat Usaha <span class="text-red-500">*</span></label>
                            <textarea wire:model="businessAddress" rows="2" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500" placeholder="Alamat lengkap usaha"></textarea>
                            @error('businessAddress') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-craft-700 mb-1">No. Telepon Usaha</label>
                            <input type="text" wire:model="businessPhone" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500" placeholder="Kosongkan jika sama dengan HP pemilik">
                        </div>
                    </div>
                </div>

                {{-- Opsi --}}
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="autoVerify" class="rounded border-craft-300 text-craft-600 focus:ring-craft-500">
                        <span class="ml-2 text-sm text-craft-700">Langsung verifikasi UMKM ini</span>
                    </label>
                </div>

                {{-- Info Password --}}
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-amber-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-amber-700">
                            <p class="font-medium">Informasi Login untuk Pemilik UMKM:</p>
                            <p>Password default: umkm + 4 digit terakhir No. HP</p>
                            <p class="text-xs mt-1">Contoh: No. HP 081234567890 → Password: umkm7890</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-craft-600 hover:bg-craft-700 text-white font-medium px-6 py-2 rounded-lg transition flex items-center gap-2" wire:loading.attr="disabled">
                        <svg wire:loading wire:target="createUmkm" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="createUmkm">Daftarkan UMKM</span>
                        <span wire:loading wire:target="createUmkm">Menyimpan...</span>
                    </button>
                    <button type="button" wire:click="closeAddForm" class="bg-craft-100 hover:bg-craft-200 text-craft-700 font-medium px-6 py-2 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @elseif(!$showDetail)
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-craft-800">Daftar UMKM</h2>
            <button wire:click="openAddForm" class="bg-craft-600 hover:bg-craft-700 text-white font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Daftarkan UMKM
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari UMKM..." 
                    class="flex-1 rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                <select wire:model.live="filterStatus" class="rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                    <option value="">Semua Status</option>
                    <option value="verified">Terverifikasi</option>
                    <option value="pending">Belum Verifikasi</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-craft-200">
                <thead class="bg-craft-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Nama Usaha</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Pemilik</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Kontak</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Terdaftar</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-craft-200">
                    @forelse($umkmList as $umkm)
                        <tr>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium text-craft-900">{{ $umkm->business_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-700">{{ $umkm->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm text-craft-700">{{ $umkm->phone ?? '-' }}</div>
                                @if($umkm->email)
                                    <div class="text-sm text-craft-500">{{ $umkm->email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($umkm->is_verified)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Terverifikasi</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-500">{{ $umkm->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center text-sm space-x-2">
                                <button wire:click="viewDetail({{ $umkm->id }})" class="text-craft-600 hover:text-craft-900">Detail</button>
                                @if($umkm->is_verified)
                                    <button @click="$dispatch('show-confirm', {
                                        title: 'Cabut Verifikasi',
                                        message: 'Yakin ingin mencabut verifikasi UMKM ini?',
                                        type: 'warning',
                                        confirmText: 'Ya, Cabut',
                                        onConfirm: () => $wire.unverify({{ $umkm->id }})
                                    })" class="text-yellow-600 hover:text-yellow-900">Cabut Verifikasi</button>
                                @else
                                    <button wire:click="verify({{ $umkm->id }})" class="text-green-600 hover:text-green-900">Verifikasi</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-craft-500">Belum ada UMKM terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $umkmList->links() }}
        </div>
    @else
        {{-- Detail View --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-craft-800">{{ $selectedUmkm->business_name }}</h2>
                    <p class="text-craft-500">Pemilik: {{ $selectedUmkm->user->name ?? '-' }}</p>
                </div>
                <button wire:click="closeDetail" class="text-craft-500 hover:text-craft-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-craft-500">Status</label>
                        @if($selectedUmkm->is_verified)
                            <p class="text-craft-700">Terverifikasi ({{ $selectedUmkm->verified_at?->format('d M Y H:i') }})</p>
                        @else
                            <p class="text-craft-700">Belum Diverifikasi</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-500">Deskripsi</label>
                        <p class="text-craft-700">{{ $selectedUmkm->description ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-500">Alamat</label>
                        <p class="text-craft-700">{{ $selectedUmkm->address ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-500">Telepon</label>
                        <p class="text-craft-700">{{ $selectedUmkm->phone ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-500">Email</label>
                        <p class="text-craft-700">{{ $selectedUmkm->email ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-500">Terdaftar</label>
                        <p class="text-craft-700">{{ $selectedUmkm->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-craft-500">Total Produk</label>
                        <p class="text-craft-700">{{ $selectedUmkm->products->count() }} produk</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-craft-500 mb-2">Foto</label>
                        @if($selectedUmkm->photos->count() > 0)
                            <div class="space-y-2">
                                @foreach($selectedUmkm->photos->take(4) as $photo)
                                    <img src="{{ Storage::url($photo->path) }}" alt="Foto UMKM" class="max-w-[50%] h-auto object-contain rounded-lg bg-craft-50">
                                @endforeach
                            </div>
                        @else
                            <p class="text-craft-500 text-sm">Belum ada foto</p>
                        @endif
                    </div>

                    {{-- Location Map --}}
                    <div>
                        <label class="block text-sm font-medium text-craft-500 mb-2">Lokasi di Peta</label>
                        @if($selectedUmkm->latitude && $selectedUmkm->longitude)
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $selectedUmkm->latitude }},{{ $selectedUmkm->longitude }}" 
                               target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-craft-500 hover:bg-craft-600 text-white text-sm font-medium rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Petunjuk Arah
                            </a>
                        @else
                            <p class="text-craft-500 text-sm">Lokasi belum ditentukan</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mt-6 pt-6 border-t border-craft-200">
                @if($selectedUmkm?->is_verified)
                    <button @click="$dispatch('show-confirm', {
                        title: 'Cabut Verifikasi',
                        message: 'Yakin ingin mencabut verifikasi UMKM ini?',
                        type: 'warning',
                        confirmText: 'Ya, Cabut',
                        onConfirm: () => $wire.unverify({{ $selectedUmkm->id }})
                    })" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
                        Cabut Verifikasi
                    </button>
                @else
                    <button wire:click="verify({{ $selectedUmkm->id }})" 
                        class="bg-craft-600 hover:bg-craft-700 text-white px-4 py-2 rounded-lg">
                        Verifikasi UMKM
                    </button>
                @endif
                <button @click="$dispatch('show-confirm', {
                    title: 'Hapus UMKM',
                    message: 'Yakin ingin menghapus UMKM ini? Semua data termasuk produk akan ikut terhapus.',
                    type: 'danger',
                    confirmText: 'Ya, Hapus',
                    onConfirm: () => $wire.delete({{ $selectedUmkm->id }})
                })" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Hapus UMKM
                </button>
                <button wire:click="closeDetail" class="bg-craft-100 hover:bg-craft-200 text-craft-700 font-medium px-4 py-2 rounded-lg transition">
                    Kembali
                </button>
            </div>
        </div>
    @endif
</div>
