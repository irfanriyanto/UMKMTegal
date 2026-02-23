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
    <div>
        <input 
            type="text" 
            x-ref="searchInput"
            placeholder="Cari alamat atau nama tempat..."
            class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500"
        >
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

    <!-- No API Key Message -->
    @if(!config('services.google_maps.api_key'))
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-700 text-sm">
        <p class="font-medium">Google Maps tidak tersedia</p>
        <p>API key belum dikonfigurasi. Hubungi administrator.</p>
    </div>
    @endif
</div>

@once
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('mapPicker', (initialLat, initialLng) => ({
        map: null,
        marker: null,
        autocomplete: null,
        latitude: initialLat,
        longitude: initialLng,
        mapReady: false,

        init() {
            if (typeof loadGoogleMaps === 'function') {
                loadGoogleMaps(() => this.initMap());
            }
        },

        initMap() {
            const defaultLat = this.latitude || -6.8797;
            const defaultLng = this.longitude || 109.1256;
            
            this.map = new google.maps.Map(this.$refs.mapContainer, {
                center: { lat: defaultLat, lng: defaultLng },
                zoom: this.latitude ? 15 : 12,
                mapTypeControl: false,
                streetViewControl: false,
            });

            if (this.latitude && this.longitude) {
                this.placeMarker({ lat: this.latitude, lng: this.longitude });
            }

            this.map.addListener('click', (e) => {
                this.placeMarker(e.latLng.toJSON());
                this.updateCoordinates(e.latLng.lat(), e.latLng.lng());
            });

            // Initialize Places Autocomplete
            this.autocomplete = new google.maps.places.Autocomplete(this.$refs.searchInput, {
                componentRestrictions: { country: 'id' },
                fields: ['geometry', 'name'],
            });

            this.autocomplete.addListener('place_changed', () => {
                const place = this.autocomplete.getPlace();
                if (place.geometry) {
                    const location = place.geometry.location;
                    this.map.setCenter(location);
                    this.map.setZoom(17);
                    this.placeMarker(location.toJSON());
                    this.updateCoordinates(location.lat(), location.lng());
                }
            });

            this.mapReady = true;
        },

        placeMarker(position) {
            if (this.marker) {
                this.marker.setPosition(position);
            } else {
                this.marker = new google.maps.Marker({
                    position: position,
                    map: this.map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                });

                this.marker.addListener('dragend', (e) => {
                    this.updateCoordinates(e.latLng.lat(), e.latLng.lng());
                });
            }
        },

        updateCoordinates(lat, lng) {
            this.latitude = lat;
            this.longitude = lng;
            this.$dispatch('location-selected', { latitude: lat, longitude: lng });
        },

        useMyLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        this.map.setCenter({ lat, lng });
                        this.map.setZoom(17);
                        this.placeMarker({ lat, lng });
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
