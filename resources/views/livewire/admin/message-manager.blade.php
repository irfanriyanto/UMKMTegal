<div x-data="{ deleteId: null }">
    @if(!$showDetail)
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-craft-800">Pesan Masuk</h2>
            @if($unreadCount > 0)
                <p class="text-sm text-craft-500">{{ $unreadCount }} pesan belum dibaca</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pesan..." 
                    class="flex-1 rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                <select wire:model.live="filterStatus" class="rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500">
                    <option value="">Semua Pesan</option>
                    <option value="unread">Belum Dibaca</option>
                    <option value="read">Sudah Dibaca</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-craft-200">
                <thead class="bg-craft-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Pengirim</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Subjek</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-craft-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-craft-200">
                    @forelse($messages as $msg)
                        <tr class="{{ !$msg->is_read ? 'bg-gray-100' : '' }}">
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm font-medium {{ !$msg->is_read ? 'text-craft-900 font-bold' : 'text-craft-700' }}">{{ $msg->name }}</div>
                                <div class="text-sm text-craft-500">{{ $msg->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm {{ !$msg->is_read ? 'text-craft-800 font-semibold' : 'text-craft-700' }}">{{ Str::limit($msg->subject, 40) }}</div>
                                <div class="text-sm text-craft-500">{{ Str::limit($msg->message, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($msg->is_read)
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Dibaca</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-craft-600">Baru</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-craft-500">{{ $msg->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-center text-sm space-x-2">
                                <button wire:click="viewDetail({{ $msg->id }})" class="text-craft-600 hover:text-craft-900">Lihat</button>
                                <button @click="$dispatch('show-confirm', {
                                    title: 'Hapus Pesan',
                                    message: 'Yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.',
                                    type: 'danger',
                                    confirmText: 'Ya, Hapus',
                                    onConfirm: () => $wire.delete({{ $msg->id }})
                                })" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-craft-500">Belum ada pesan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    @else
        {{-- Detail View --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-craft-800">{{ $selectedMessage->subject }}</h2>
                    <p class="text-craft-500">Dari: {{ $selectedMessage->name }} ({{ $selectedMessage->email }})</p>
                </div>
                <button wire:click="closeDetail" class="text-craft-500 hover:text-craft-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-4 text-sm text-craft-500">
                    <span>{{ $selectedMessage->created_at->format('d M Y H:i') }}</span>
                    @if($selectedMessage->is_read)
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Sudah Dibaca</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-craft-600">Baru</span>
                    @endif
                </div>

                <div class="border-t border-craft-200 pt-4">
                    <label class="block text-sm font-medium text-craft-500 mb-2">Pesan</label>
                    <div class="bg-craft-50 rounded-lg p-4">
                        <p class="text-craft-700 whitespace-pre-wrap">{{ $selectedMessage->message }}</p>
                    </div>
                </div>

                <div class="border-t border-craft-200 pt-4">
                    <label class="block text-sm font-medium text-craft-500 mb-2">Balas via Email</label>
                    <a href="mailto:{{ $selectedMessage->email }}?subject=Re: {{ $selectedMessage->subject }}" 
                        class="inline-flex items-center text-craft-600 hover:text-craft-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ $selectedMessage->email }}
                    </a>
                </div>
            </div>

            <div class="flex gap-4 mt-6 pt-6 border-t border-craft-200">
                @if($selectedMessage->is_read)
                    <button wire:click="markAsUnread({{ $selectedMessage->id }})" 
                        class="bg-craft-600 hover:bg-craft-700 text-white px-4 py-2 rounded-lg">
                        Tandai Belum Dibaca
                    </button>
                @endif
                <button @click="$dispatch('show-confirm', {
                    title: 'Hapus Pesan',
                    message: 'Yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.',
                    type: 'danger',
                    confirmText: 'Ya, Hapus',
                    onConfirm: () => $wire.delete({{ $selectedMessage->id }})
                })" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Hapus Pesan
                </button>
                <button wire:click="closeDetail" class="bg-craft-100 hover:bg-craft-200 text-craft-700 font-medium px-4 py-2 rounded-lg transition">
                    Kembali
                </button>
            </div>
        </div>
    @endif
</div>
