<div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-craft-800 mb-6">
            {{ $profile ? 'Edit Profil Usaha' : 'Daftarkan Usaha Anda' }}
        </h2>

        <form wire:submit="save" class="space-y-6">
            <!-- Business Name -->
            <div>
                <label class="block text-sm font-medium text-craft-700 mb-1">Nama Usaha *</label>
                <input type="text" wire:model="business_name" 
                    class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                    placeholder="Contoh: Batik Sari Indah">
                @error('business_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-craft-700 mb-1">Deskripsi Usaha *</label>
                <textarea wire:model="description" rows="4"
                    class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                    placeholder="Ceritakan tentang usaha Anda, produk yang dijual, keunikan, dll..."></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Contact Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Nomor Telepon *</label>
                    <input type="text" wire:model="phone" 
                        class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                        placeholder="08123456789">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Email (Opsional)</label>
                    <input type="email" wire:model="email" 
                        class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                        placeholder="usaha@email.com">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-craft-700 mb-1">Alamat Lengkap *</label>
                <textarea wire:model="address" rows="2"
                    class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                    placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota"></textarea>
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Location Map Picker -->
            <div>
                <label class="block text-sm font-medium text-craft-700 mb-1">Lokasi di Peta (Opsional)</label>
                <p class="text-xs text-craft-500 mb-3">Klik pada peta atau gunakan pencarian untuk menandai lokasi usaha Anda. Lokasi ini akan ditampilkan kepada pengunjung.</p>
                
                <div x-on:location-selected="$wire.set('latitude', $event.detail.latitude); $wire.set('longitude', $event.detail.longitude)">
                    <x-map-picker 
                        :latitude="$latitude" 
                        :longitude="$longitude" 
                        height="350px"
                    />
                </div>
                
                @error('latitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('longitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Social Media -->
            <div>
                <label class="block text-sm font-medium text-craft-700 mb-3">Media Sosial (Opsional)</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            <input type="text" wire:model="instagram" 
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="Username Instagram (Tanpa tanda @)">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <input type="text" wire:model="facebook" 
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="Username Facebook (Tanpa tanda @)">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <input type="text" wire:model="whatsapp" 
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="Nomor WhatsApp">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Upload -->
            <div>
                <label class="block text-sm font-medium text-craft-700 mb-1">Foto Usaha *</label>
                
                <!-- Existing Photos -->
                @if(count($existingPhotos) > 0)
                    <div class="flex flex-wrap gap-4 mb-4">
                        @foreach($existingPhotos as $photo)
                            <div class="relative">
                                <img src="{{ Storage::url($photo['path']) }}" alt="Foto usaha" class="w-24 h-24 object-cover rounded-lg">
                                <button type="button" wire:click="deletePhoto({{ $photo['id'] }})" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(count($existingPhotos) == 0)
                    <input type="file" wire:model="photo" accept=".jpg,.jpeg,.png"
                        class="w-full text-sm text-craft-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-craft-100 file:text-craft-700 hover:file:bg-craft-200">
                    <p class="text-xs text-craft-500 mt-1">Upload maksimal 1 foto dengan ukuran maksimal 2MB. Format: JPG, JPEG atau PNG.</p>
                    <p class="text-xs text-amber-600 mt-1">Upload foto dengan rasio 1:1, foto dengan rasio portrait atau landscape akan terpotong otomatis menjadi rasio 1:1.</p>
                @else
                    <p class="text-xs text-amber-600">Hapus foto yang ada untuk mengganti dengan foto baru.</p>
                @endif
                @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                
                @if($photo && is_object($photo) && method_exists($photo, 'temporaryUrl'))
                    <div class="mt-2">
                        <p class="text-sm text-craft-600">Preview:</p>
                        <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mt-1">
                    </div>
                @endif
            </div>

            <!-- Submit -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-craft-500 hover:bg-craft-600 text-white px-6 py-2 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="save" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">{{ $profile ? 'Simpan Perubahan' : 'Daftarkan Usaha' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
                @if($profile)
                    <a href="{{ route('umkm.show', $profile->slug) }}" target="_blank" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
                        Lihat Profil Publik
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
