<div>
    @if(!$showForm)
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-craft-800">Daftar Artikel</h2>
            <button wire:click="create" class="bg-craft-500 hover:bg-craft-600 text-white px-4 py-2 rounded-lg">
                + Tambah Artikel
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-craft-200">
                <thead class="bg-craft-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-craft-200">
                    @forelse($articles as $article)
                        <tr>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium text-craft-900">{{ Str::limit($article->title, 50) }}</div>
                                <div class="text-sm text-craft-500">{{ $article->author->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-500">{{ $article->category ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="togglePublish({{ $article->id }})" class="px-2 py-1 text-xs rounded-full {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $article->is_published ? 'Dipublikasi' : 'Draft' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-500">{{ $article->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center text-sm space-x-2">
                                <button wire:click="edit({{ $article->id }})" class="text-craft-600 hover:text-craft-900">Edit</button>
                                <button @click="$dispatch('show-confirm', {
                                    title: 'Hapus Artikel',
                                    message: 'Yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.',
                                    type: 'danger',
                                    confirmText: 'Ya, Hapus',
                                    onConfirm: () => $wire.delete({{ $article->id }})
                                })" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-craft-500">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-craft-800 mb-6">{{ $isEditing ? 'Edit Artikel' : 'Tambah Artikel' }}</h2>
            
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Judul</label>
                    <input type="text" wire:model="title" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Kategori</label>
                    <input type="text" wire:model="category" placeholder="Contoh: Tips, Edukasi, Berita" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Konten</label>
                    <textarea wire:model="content" rows="10" class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"></textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-craft-700 mb-1">Gambar Utama *</label>
                    
                    @if($isEditing && $editingId)
                        @php $editArticle = \App\Models\Article::find($editingId); @endphp
                        @if($editArticle && $editArticle->featured_image)
                            <div class="mb-2">
                                <p class="text-sm text-craft-500 mb-1">Gambar saat ini:</p>
                                <img src="{{ Storage::url($editArticle->featured_image) }}" alt="Featured" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                    @endif
                    
                    <input type="file" wire:model="featured_image" accept=".jpg,.jpeg,.png"
                        class="w-full text-sm text-craft-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-craft-100 file:text-craft-700 hover:file:bg-craft-200">
                    <p class="text-xs text-craft-500 mt-1">Upload maksimal 1 foto dengan ukuran maksimal 2MB. Format: JPG, JPEG atau PNG.</p>
                    <p class="text-xs text-amber-600 mt-1">Upload foto dengan rasio 1:1, foto dengan rasio portrait atau landscape akan terpotong otomatis menjadi rasio 1:1.</p>
                    @error('featured_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    @if($featured_image && is_object($featured_image) && method_exists($featured_image, 'temporaryUrl'))
                        <div class="mt-2">
                            <p class="text-sm text-craft-600">Preview:</p>
                            <img src="{{ $featured_image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mt-1">
                        </div>
                    @endif
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_published" id="is_published" class="rounded border-craft-300 text-craft-600 focus:ring-craft-500">
                    <label for="is_published" class="ml-2 text-sm text-craft-700">Publikasikan sekarang</label>
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
