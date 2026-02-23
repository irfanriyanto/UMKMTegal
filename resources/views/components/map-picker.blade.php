@props([
    'latitude' => null,
    'longitude' => null,
    'height' => '400px',
])

<div 
    x-data="mapPicker(@js($latitude), @js($longitude))"
    x-init="init()"
    class="space-y-3"
>
    <!-- Search Box -->
    <div class="relative">
        <input 
            type="text" 
            x-ref="searchInput"
            x-model="searchQuery"
            @keydown.enter.prevent="searchLocation()"
            placeholder="Cari alamat atau nama tempat..."
            class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 pr-10"
        >
        <button 
            type="button"
            @click="searchLocation()"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-craft-500 hover:text-craft-700 p-1"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
        <!-- Search Results Dropdown -->
        <div x-show="searchResults.length > 0" x-cloak 
            class="absolute z-[1000] w-full mt-1 bg-white border border-craft-300 rounded-lg shadow-lg max-h-48 overflow-y-auto">
            <template x-for="(result, index) in searchResults" :key="index">
                <button type="button" 
                    @click="selectSearchResult(result)"
                    class="w-full text-left px-4 py-2 text-sm hover:bg-craft-50 border-b border-craft-100 last:border-b-0">
                    <span x-text="result.display_name" class="line-clamp-2"></span>
                </button>
            </template>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-2 mt-2 mb-3">
        <button 
            type="button"
            @click="useMyLocation()"
            class="inline-flex items-center px-3 py-2 text-sm bg-craft-100 hover:bg-craft-200 text-craft-700 rounded-lg transition"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0013 3.06V1h-2v2.06A8.994 8.994 0 003.06 11H1v2h2.06A8.994 8.994 0 0011 20.94V23h2v-2.06A8.994 8.994 0 0020.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
            </svg>
            Gunakan Lokasi Saya
        </button>
    </div>

    <!-- Map Container -->
    <div 
        x-ref="mapContainer" 
        class="rounded-lg border border-craft-300 overflow-hidden"
        style="height: {{ $height }}"
    >
        <template x-if="!mapReady">
            <div class="w-full h-full flex items-center justify-center bg-craft-100">
                <div class="text-center text-craft-500">
                    <svg class="animate-spin h-8 w-8 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p>Memuat peta...</p>
                </div>
            </div>
        </template>
    </div>

    <!-- Coordinates Display -->
    <div class="flex gap-4 text-sm text-craft-600">
        <div>
            <span class="font-medium">Latitude:</span> 
            <span x-text="latitude ? latitude.toFixed(6) : '-'"></span>
        </div>
        <div>
            <span class="font-medium">Longitude:</span> 
            <span x-text="longitude ? longitude.toFixed(6) : '-'"></span>
        </div>
    </div>

    <!-- Hidden inputs for form submission -->
    <input type="hidden" name="latitude" :value="latitude">
    <input type="hidden" name="longitude" :value="longitude">
</div>

@once
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('mapPicker', (initialLat, initialLng) => ({
        map: null,
        marker: null,
        latitude: initialLat,
        longitude: initialLng,
        mapReady: false,
        searchQuery: '',
        searchResults: [],
        searchTimeout: null,

        init() {
            this.$nextTick(() => {
                this.initMap();
            });
        },

        initMap() {
            const defaultLat = this.latitude || -6.8797;
            const defaultLng = this.longitude || 109.1256;
            
            this.map = L.map(this.$refs.mapContainer).setView([defaultLat, defaultLng], this.latitude ? 15 : 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(this.map);

            if (this.latitude && this.longitude) {
                this.placeMarker([this.latitude, this.longitude]);
            }

            this.map.on('click', (e) => {
                this.placeMarker([e.latlng.lat, e.latlng.lng]);
                this.updateCoordinates(e.latlng.lat, e.latlng.lng);
            });

            this.mapReady = true;

            // Fix map rendering in hidden/dynamic containers
            setTimeout(() => {
                this.map.invalidateSize();
            }, 200);
        },

        placeMarker(latlng) {
            if (this.marker) {
                this.marker.setLatLng(latlng);
            } else {
                this.marker = L.marker(latlng, { draggable: true }).addTo(this.map);

                this.marker.on('dragend', (e) => {
                    const pos = e.target.getLatLng();
                    this.updateCoordinates(pos.lat, pos.lng);
                });
            }
        },

        updateCoordinates(lat, lng) {
            this.latitude = lat;
            this.longitude = lng;
            this.$dispatch('location-selected', { latitude: lat, longitude: lng });
        },

        async searchLocation() {
            if (!this.searchQuery || this.searchQuery.trim().length < 3) return;

            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&countrycodes=id&limit=5`,
                    { headers: { 'Accept-Language': 'id' } }
                );
                this.searchResults = await response.json();
            } catch (error) {
                console.error('Search failed:', error);
                this.searchResults = [];
            }
        },

        selectSearchResult(result) {
            const lat = parseFloat(result.lat);
            const lng = parseFloat(result.lon);
            this.map.setView([lat, lng], 17);
            this.placeMarker([lat, lng]);
            this.updateCoordinates(lat, lng);
            this.searchResults = [];
            this.searchQuery = result.display_name;
        },

        useMyLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        this.map.setView([lat, lng], 17);
                        this.placeMarker([lat, lng]);
                        this.updateCoordinates(lat, lng);
                    },
                    (error) => {
                        alert('Tidak dapat mengakses lokasi. Pastikan izin lokasi diaktifkan.');
                    }
                );
            } else {
                alert('Browser tidak mendukung geolokasi.');
            }
        }
    }));
});
</script>
@endpush
@endonce
