<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-craft-800 leading-tight">
            Dukung Kami
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-craft-800 mb-4">Dukung UMKMPedia</h1>
                    <p class="text-craft-600 max-w-2xl mx-auto">
                        Platform ini 100% gratis untuk UMKM Lokal. Dukungan Anda membantu kami menutupi biaya operasional, research dan pengembangan fitur baru.
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-craft-50 p-5 rounded-lg border-l-4 border-craft-500 mb-8">
                    <p class="text-craft-700">
                        <strong>Mengapa Kami Butuh Dukungan?</strong>
                    </p>
                    <ul class="text-craft-600 mt-2 space-y-1 text-sm">
                        <li>• Biaya domain dan hosting</li>
                        <li>• Pengembangan fitur baru</li>
                        <li>• Pemeliharaan dan keamanan website</li>
                        <li>• Agar platform tetap gratis untuk semua UMKM Lokal</li>
                    </ul>
                </div>

                <!-- Donation Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- QRIS DANA -->
                    <div class="bg-white border-2 border-craft-200 rounded-xl p-6 text-center">
                        <h3 class="text-lg font-semibold text-craft-800 mb-4">Transfer via QRIS</h3>
                        <div class="mb-4">
                            <img src="{{ asset('images/qris-dana.png') }}" alt="QRIS DANA" class="w-48 h-48 mx-auto object-contain">
                        </div>
                        <p class="text-sm text-craft-600">Scan QRIS di atas menggunakan aplikasi E-Wallet atau Mobile Banking Anda</p>
                    </div>

                    <!-- Saweria -->
                    <div class="bg-white border-2 border-craft-200 rounded-xl p-6 text-center">
                        <h3 class="text-lg font-semibold text-craft-800 mb-4">Donasi via Saweria</h3>
                        <div class="mb-4">
                            <img src="{{ asset('images/saweria.png') }}" alt="Saweria" class="w-48 h-48 mx-auto object-contain">
                        </div>
                        <a href="https://saweria.co/irfanriyanto" target="_blank" rel="noopener noreferrer" 
                           class="inline-block w-full bg-craft-600 hover:bg-craft-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Donasi via Saweria
                        </a>
                        <p class="text-sm text-craft-600 mt-3">Scan QR atau klik tombol di atas, pilih nominal, bayar via QRIS atau E-Wallet</p>
                    </div>
                </div>

                <!-- Thank You Message -->
                <div class="mt-8 text-center bg-craft-50 rounded-lg p-6 border border-craft-200">
                    <svg class="w-12 h-12 mx-auto text-craft-500 mb-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-craft-800 mb-2">Terima Kasih!</h3>
                    <p class="text-craft-700 text-sm">
                        Setiap dukungan sangat berarti bagi kami dan ribuan UMKM Lokal yang menggunakan platform ini.
                        Bersama-sama kita majukan UMKM Lokal di Indonesia!
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
