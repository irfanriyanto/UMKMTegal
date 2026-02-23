<div>
    @if($event)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- Event Banner Image - Fixed 1:1 ratio --}}
            <div class="flex justify-center py-6 bg-craft-50" style="box-shadow: inset 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                @if($event->banner_image)
                    <div class="overflow-hidden rounded-lg shadow-md flex-shrink-0" style="width: 320px; height: 320px;">
                        <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="bg-gradient-to-br from-craft-400 to-kayu-500 flex items-center justify-center text-white rounded-lg flex-shrink-0" style="width: 320px; height: 320px;">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-8">
                @if($event->isOngoing())
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Sedang Berlangsung</span>
                @elseif($event->isUpcoming())
                    <span class="bg-craft-500 text-white px-3 py-1 rounded-full text-sm">{{ $event->start_date->diffForHumans() }}</span>
                @endif
                <h1 class="text-3xl font-bold text-craft-800 mt-4">{{ $event->name }}</h1>
                <div class="flex items-center gap-2 mt-4 text-craft-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}</span>
                </div>
                @if($event->location)
                <div class="flex items-center gap-2 mt-2 text-craft-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
                @endif
                <div class="mt-6 prose prose-craft max-w-none whitespace-pre-line" style="text-align: justify;">
                    {{ $event->description }}
                </div>
            </div>
        </div>

        @if($event->umkmProfiles->count() > 0)
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-craft-800 mb-4">UMKM Peserta</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($event->umkmProfiles as $umkm)
                        <a href="{{ route('umkm.show', $umkm->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="h-28 bg-craft-100">
                                @if($umkm->primaryPhoto())
                                    <img src="{{ Storage::url($umkm->primaryPhoto()->path) }}" alt="{{ $umkm->business_name }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-craft-800 text-sm">{{ $umkm->business_name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <p class="text-craft-500">Event tidak ditemukan.</p>
            <a href="{{ route('events.index') }}" class="text-craft-600 hover:underline mt-4 inline-block">Kembali ke daftar event</a>
        </div>
    @endif
</div>
