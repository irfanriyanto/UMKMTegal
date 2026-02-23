<div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($events as $event)
            <a href="{{ route('events.show', $event->slug) }}" class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-square bg-craft-100 relative overflow-hidden">
                    @if($event->banner_image)
                        <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-craft-400 to-kayu-500 text-white">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    @if($event->isOngoing())
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">
                            Sedang Berlangsung
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-craft-800 group-hover:text-craft-600 transition-colors line-clamp-2">{{ $event->name }}</h3>
                    <div class="flex items-center gap-2 mt-2 text-sm text-craft-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $event->start_date->format('d M Y') }}</span>
                    </div>
                    @if($event->isUpcoming())
                        <div class="mt-2 text-xs text-batik-600 font-medium">
                            {{ $event->start_date->diffForHumans() }}
                        </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-craft-500">
                <p>Tidak ada event mendatang.</p>
            </div>
        @endforelse
    </div>

    @if($events->count() > 0)
        <div class="text-center mt-8">
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-craft-600 hover:text-craft-800 font-medium">
                Lihat Semua Event
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endif
</div>
