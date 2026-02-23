<div>
    @if(!$stats['has_profile'])
        <!-- No Profile Alert -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Profil Usaha Belum Lengkap</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        Lengkapi profil usaha Anda terlebih dahulu untuk mulai menambahkan produk.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('umkm.profile') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg">
                            Lengkapi Profil Usaha
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Verification Status -->
        @if(!$stats['is_verified'])
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-xl">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Menunggu Verifikasi</h3>
                        <p class="mt-1 text-sm text-blue-700">
                            Profil usaha Anda sedang dalam proses verifikasi oleh admin. Anda tetap bisa menambahkan produk.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 rounded-full bg-craft-100">
                        <svg class="w-6 h-6 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-craft-500">Total Produk</p>
                        <p class="text-2xl font-bold text-craft-800">{{ $stats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 rounded-full bg-craft-100">
                        <svg class="w-6 h-6 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-craft-500">Produk Aktif</p>
                        <p class="text-2xl font-bold text-craft-800">{{ $stats['active_products'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-3 rounded-full bg-craft-100">
                        <svg class="w-6 h-6 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-craft-500">Produk Tidak Aktif</p>
                        <p class="text-2xl font-bold text-craft-800">{{ $stats['inactive_products'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-craft-800">Profil Usaha</h3>
                <a href="{{ route('umkm.profile') }}" class="text-craft-500 hover:text-craft-700 text-sm">Edit Profil</a>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-20 h-20 bg-craft-100 rounded-xl flex items-center justify-center text-3xl">
                    @if($profile->primaryPhoto())
                        <img src="{{ Storage::url($profile->primaryPhoto()->path) }}" alt="{{ $profile->business_name }}" class="w-20 h-20 rounded-xl object-cover">
                    @else
                        🏪
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <h4 class="text-xl font-semibold text-craft-800">{{ $profile->business_name }}</h4>
                        @if($stats['is_verified'])
                            <span class="px-2 py-1 text-xs bg-craft-500 text-white rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Terverifikasi
                            </span>
                        @endif
                    </div>
                    <p class="text-craft-600 mt-1">{{ Str::limit($profile->description, 150) }}</p>
                    <div class="flex gap-4 mt-2 text-sm text-craft-500">
                        @if($profile->phone)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $profile->phone }}
                            </span>
                        @endif
                        @if($profile->address)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-craft-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ Str::limit($profile->address, 30) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
