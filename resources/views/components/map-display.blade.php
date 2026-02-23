@props([
    'latitude',
    'longitude',
    'height' => '300px',
    'title' => 'Lokasi',
])

@php
    $lat = is_numeric($latitude) ? (float) $latitude : null;
    $lng = is_numeric($longitude) ? (float) $longitude : null;
@endphp

@if($lat && $lng)
<div 
    x-data="mapDisplay({{ $lat }}, {{ $lng }}, @js($title))"
    x-init="init()"
    class="space-y-4"
>
    <!-- Map Container -->
    <div 
        x-ref="mapContainer" 
        class="rounded-lg border border-craft-300 overflow-hidden"
        style="height: {{ $height }}"
    >
        <!-- Loading indicator shown inside map container -->
        <div x-show="!mapReady" class="w-full h-full flex items-center justify-center bg-craft-100">
            <div class="text-center text-craft-500">
                <svg class="animate-spin h-8 w-8 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p>Memuat peta...</p>
            </div>
        </div>
    </div>

    <!-- Get Directions Button -->
    <a 
        href="https://www.openstreetmap.org/directions?from=&to={{ $lat }}%2C{{ $lng }}"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center px-4 py-2 bg-craft-500 hover:bg-craft-600 text-white rounded-lg transition text-sm"
    >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
        </svg>
        Petunjuk Arah
    </a>
</div>
@endif

@once
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('mapDisplay', (lat, lng, title) => ({
        map: null,
        marker: null,
        mapReady: false,

        init() {
            lat = parseFloat(lat);
            lng = parseFloat(lng);
            
            this.$nextTick(() => {
                this.initMap(lat, lng, title);
            });
        },

        initMap(lat, lng, title) {
            const mapContainer = this.$refs.mapContainer;

            this.map = L.map(mapContainer).setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(this.map);

            this.marker = L.marker([lat, lng]).addTo(this.map);
            this.marker.bindPopup(`<div class="font-medium p-1">${title}</div>`).openPopup();

            this.mapReady = true;

            // Fix map rendering in hidden/dynamic containers
            setTimeout(() => {
                this.map.invalidateSize();
            }, 200);
        }
    }));
});
</script>
@endpush
@endonce
