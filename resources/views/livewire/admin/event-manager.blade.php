<div>
    @if(!$showForm)
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-craft-800">Daftar Event</h2>
            <button wire:click="create" class="bg-craft-500 hover:bg-craft-600 text-white px-4 py-2 rounded-lg">
                + Tambah Event
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-craft-200">
                <thead class="bg-craft-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Nama Event</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Lokasi</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-craft-200">
                    @forelse($events as $event)
                        <tr>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium text-craft-900">{{ $event->name }}</div>
                                <div class="text-sm text-craft-500">{{ Str::limit($event->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-500">
                                {{ $event->location ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-500">
                                {{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="toggleActive({{ $event->id }})" class="px-2 py-1 text-xs rounded-full {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                                @if($event->isOngoing())
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Berlangsung</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm space-x-2">
                                <button wire:click="edit({{ $event->id }})" class="text-craft-600 hover:text-craft-900">Edit</button>
                                <button @click="$dispatch('show-confirm', {
                                    title: 'Hapus Event',
                                    message: 'Yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.',
                                    type: 'danger',
                                    confirmText: 'Ya, Hapus',
                                    onConfirm: () => $wire.delete({{ $event->id }})
                                })" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-craft-500">Belum ada event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-craft-800 mb-6">{{ $isEditing ? 'Edit Event' : 'Tambah Event' }}</h2>
            
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Nama Event</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="4" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Lokasi/Tempat</label>
                    <input type="text" wire:model="location" placeholder="Contoh: Alun-alun Kota, GOR Satria, dll" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-craft-700 mb-1">Tanggal Mulai</label>
                        <div wire:ignore>
                            <input type="text" 
                                x-data
                                x-init="flatpickr($el, {
                                    enableTime: true,
                                    time_24hr: true,
                                    dateFormat: 'Y-m-d H:i',
                                    locale: 'id',
                                    defaultDate: '{{ $start_date }}',
                                    onChange: function(selectedDates, dateStr) {
                                        @this.set('start_date', dateStr);
                                    }
                                })"
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="Pilih tanggal & waktu">
                        </div>
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-craft-700 mb-1">Tanggal Selesai</label>
                        <div wire:ignore>
                            <input type="text"
                                x-data
                                x-init="flatpickr($el, {
                                    enableTime: true,
                                    time_24hr: true,
                                    dateFormat: 'Y-m-d H:i',
                                    locale: 'id',
                                    defaultDate: '{{ $end_date }}',
                                    onChange: function(selectedDates, dateStr) {
                                        @this.set('end_date', dateStr);
                                    }
                                })"
                                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
                                placeholder="Pilih tanggal & waktu">
                        </div>
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Banner Image *</label>
                    
                    @if($isEditing && $editingId)
                        @php $editEvent = \App\Models\Event::find($editingId); @endphp
                        @if($editEvent && $editEvent->banner_image)
                            <div class="mb-2">
                                <p class="text-sm text-craft-500 mb-1">Gambar saat ini:</p>
                                <img src="{{ Storage::url($editEvent->banner_image) }}" alt="Banner" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                    @endif
                    
                    <input type="file" wire:model="banner_image" accept=".jpg,.jpeg,.png"
                        class="w-full text-sm text-craft-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-craft-100 file:text-craft-700 hover:file:bg-craft-200">
                    <p class="text-xs text-craft-500 mt-1">Upload maksimal 1 foto dengan ukuran maksimal 2MB. Format: JPG, JPEG atau PNG.</p>
                    <p class="text-xs text-amber-600 mt-1">Upload foto dengan rasio 1:1, foto dengan rasio portrait atau landscape akan terpotong otomatis menjadi rasio 1:1.</p>
                    @error('banner_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    @if($banner_image && is_object($banner_image) && method_exists($banner_image, 'temporaryUrl'))
                        <div class="mt-2">
                            <p class="text-sm text-craft-600">Preview:</p>
                            <img src="{{ $banner_image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mt-1">
                        </div>
                    @endif
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-craft-300 text-craft-600 focus:ring-craft-500">
                    <label for="is_active" class="ml-2 text-sm text-craft-700">Event Aktif</label>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="bg-craft-500 hover:bg-craft-600 text-white px-6 py-2 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" wire:loading.attr="disabled">
                        <svg wire:loading wire:target="save" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="save">{{ $isEditing ? 'Perbarui' : 'Simpan' }}</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                    <button type="button" wire:click="cancel" class="bg-craft-100 hover:bg-craft-200 text-craft-700 font-medium px-6 py-2 rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
