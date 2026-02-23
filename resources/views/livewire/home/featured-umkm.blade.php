<div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($umkmList as $umkm)
            <a href="{{ route('umkm.show', $umkm->slug) }}" class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-square bg-craft-100 relative overflow-hidden">
                    @if($umkm->primaryPhoto())
                        <img src="{{ Storage::url($umkm->primaryPhoto()->path) }}" alt="{{ $umkm->business_name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-craft-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
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
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-craft-500">
                <p>Belum ada UMKM terdaftar.</p>
            </div>
        @endforelse
    </div>

    @if($umkmList->count() > 0)
        <div class="text-center mt-8">
            <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 text-craft-600 hover:text-craft-800 font-medium">
                Lihat Semua UMKM
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endif
</div>
