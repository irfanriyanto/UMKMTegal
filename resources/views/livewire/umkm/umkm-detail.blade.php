<div>
    @if($profile)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- UMKM Photo - Fixed 1:1 ratio --}}
            <div class="flex justify-center py-4 bg-craft-50 relative" style="box-shadow: inset 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                @if($profile->primaryPhoto())
                    <div class="overflow-hidden rounded-lg shadow-md flex-shrink-0" style="width: 320px; height: 320px;">
                        <img src="{{ Storage::url($profile->primaryPhoto()->path) }}" alt="{{ $profile->business_name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="bg-gradient-to-br from-craft-400 to-kayu-500 flex items-center justify-center text-white rounded-lg flex-shrink-0" style="width: 320px; height: 320px;">
                        <span class="text-lg">Tidak ada foto</span>
                    </div>
                @endif
                @if($profile->is_verified)
                    <span class="absolute top-8 right-4 bg-craft-500 text-white px-3 py-1 rounded-full text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Terverifikasi
                    </span>
                @endif
            </div>
            <div class="p-8">
                <h1 class="text-3xl font-bold text-craft-800">{{ $profile->business_name }}</h1>
                @if($profile->address)
                    <p class="text-craft-500 mt-2">{{ $profile->address }}</p>
                @endif
                <div class="mt-6 prose prose-craft">
                    {!! nl2br(e($profile->description)) !!}
                </div>
                {{-- Contact Info --}}
                <div class="mt-8 flex flex-wrap gap-4">
                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}" class="flex items-center gap-2 px-4 py-2 bg-craft-100 rounded-lg text-craft-700 hover:bg-craft-200">
                            <svg class="w-5 h-5 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $profile->phone }}
                        </a>
                    @endif
                    @if($profile->email)
                        <a href="mailto:{{ $profile->email }}" class="flex items-center gap-2 px-4 py-2 bg-craft-100 rounded-lg text-craft-700 hover:bg-craft-200">
                            <svg class="w-5 h-5 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $profile->email }}
                        </a>
                    @endif
                </div>

                {{-- Social Media --}}
                @if($profile->social_media && (($profile->social_media['instagram'] ?? null) || ($profile->social_media['facebook'] ?? null) || ($profile->social_media['whatsapp'] ?? null)))
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-craft-800 mb-3">Media Sosial</h3>
                        <div class="flex flex-wrap gap-3">
                            @if($profile->social_media['instagram'] ?? null)
                                @php
                                    $igUsername = ltrim($profile->social_media['instagram'], '@');
                                @endphp
                                <a href="https://instagram.com/{{ $igUsername }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 text-white rounded-lg transition" style="background-color: #E1306C;">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    {{ '@' . $igUsername }}
                                </a>
                            @endif
                            @if($profile->social_media['facebook'] ?? null)
                                @php
                                    $fbUsername = ltrim($profile->social_media['facebook'], '@');
                                @endphp
                                <a href="https://facebook.com/{{ $fbUsername }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 text-white rounded-lg transition" style="background-color: #1877F2;">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    {{ '@' . $fbUsername }}
                                </a>
                            @endif
                            @if($profile->social_media['whatsapp'] ?? null)
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $profile->social_media['whatsapp']);
                                    // Jika diawali 0, ganti dengan 62
                                    if (str_starts_with($waNumber, '0')) {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                    // Jika belum diawali 62, tambahkan
                                    elseif (!str_starts_with($waNumber, '62')) {
                                        $waNumber = '62' . $waNumber;
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 px-4 py-2 text-white rounded-lg transition" style="background-color: #25D366;">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    {{ $profile->social_media['whatsapp'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Location Map --}}
                @if($profile->latitude && $profile->longitude)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-craft-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Lokasi
                        </h3>
                        <x-map-display 
                            :latitude="$profile->latitude" 
                            :longitude="$profile->longitude" 
                            :title="$profile->business_name"
                            height="300px"
                        />
                    </div>
                @endif
            </div>
        </div>

        @if($profile->products->count() > 0)
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-craft-800 mb-4">Produk</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($profile->products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-square bg-craft-100 relative overflow-hidden">
                                @if($product->primaryImage())
                                    <img src="{{ Storage::url($product->primaryImage()->path) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-craft-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-craft-800 text-sm line-clamp-2 group-hover:text-craft-600 transition-colors">{{ $product->name }}</h3>
                                <p class="text-craft-600 font-semibold text-sm mt-1">{{ $product->formatted_price }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <p class="text-craft-500">UMKM tidak ditemukan.</p>
            <a href="{{ route('umkm.index') }}" class="text-craft-600 hover:underline mt-4 inline-block">Kembali ke daftar UMKM</a>
        </div>
    @endif
</div>
