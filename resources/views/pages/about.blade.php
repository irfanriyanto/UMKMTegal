<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-craft-800 leading-tight">
            Tentang Kami
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-8">
                <h1 class="text-3xl font-bold text-craft-800 mb-6">{{ config('app.name') }}</h1>
                
                <!-- Fokus Kami Banner -->
                <div class="bg-craft-50 p-5 rounded-lg border-l-4 border-craft-500 mb-8">
                    <p class="text-craft-700 font-medium mb-2">
                        <strong>#UMKMTegalGoPublic</strong> - Membawa UMKM Tegal ke Level Nasional!
                    </p>
                    <p class="text-craft-600">
                        Kami fokus untuk memajukan UMKM di Indonesia khususnya <strong>Tegal dan sekitarnya</strong>. 
                        Dengan platform ini, kami ingin membantu pelaku usaha lokal Tegal untuk lebih dikenal, 
                        meningkatkan penjualan, dan bersaing di pasar yang lebih luas. Bersama-sama, kita wujudkan 
                        <strong>#TegalBangkit</strong> dan <strong>#MajuBersamaUMKM</strong>!
                    </p>
                </div>

                <div class="prose prose-craft max-w-none">
                    <h2 class="text-xl font-semibold text-craft-700 mt-8 mb-4">Visi</h2>
                    <p class="text-craft-600">
                        Menjadi platform digital terdepan dalam mendukung pertumbuhan dan keberlanjutan Usaha Mikro, Kecil, dan Menengah (UMKM) di Indonesia khususnya <strong>Tegal</strong> dan sekitarnya, serta membawa produk lokal ke pasar yang lebih luas.
                    </p>

                    <h2 class="text-xl font-semibold text-craft-700 mt-8 mb-4">Misi</h2>
                    <ul class="list-disc list-inside text-craft-600 space-y-2">
                        <li>Menyediakan platform yang mudah digunakan untuk UMKM Tegal mempromosikan produk dan layanan mereka</li>
                        <li>Menghubungkan UMKM Tegal dengan konsumen yang mencari produk lokal berkualitas</li>
                        <li>Memberikan edukasi dan informasi untuk membantu UMKM Tegal berkembang dan go public</li>
                        <li>Memfasilitasi event dan kegiatan yang mendukung ekosistem UMKM di wilayah Tegal</li>
                        <li>Membangun kebanggaan masyarakat terhadap produk-produk asli Tegal</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-craft-700 mt-8 mb-4">Tujuan</h2>
                    <p class="text-craft-600">
                        Platform ini bertujuan untuk memberdayakan UMKM lokal Tegal dengan memberikan akses ke pasar yang lebih luas, 
                        meningkatkan visibilitas produk mereka, dan membangun komunitas yang saling mendukung antara pelaku usaha 
                        dan konsumen yang peduli dengan produk lokal Tegal.
                    </p>

                    <h2 class="text-xl font-semibold text-craft-700 mt-8 mb-4">Mengapa Memilih Kami?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-craft-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-craft-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-craft-600" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/></svg>
                                Gratis untuk UMKM
                            </h3>
                            <p class="text-sm text-craft-600 mt-1">Pendaftaran dan penggunaan platform sepenuhnya gratis</p>
                        </div>
                        <div class="bg-craft-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-craft-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-craft-600" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                Verifikasi UMKM
                            </h3>
                            <p class="text-sm text-craft-600 mt-1">Sistem verifikasi untuk menjamin keaslian usaha</p>
                        </div>
                        <div class="bg-craft-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-craft-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-craft-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                Fokus UMKM Lokal di daerah
                            </h3>
                            <p class="text-sm text-craft-600 mt-1">Khusus UMKM di daerah Tegal dan sekitarnya</p>
                        </div>
                        <div class="bg-craft-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-craft-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-craft-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                                Statistik Lengkap
                            </h3>
                            <p class="text-sm text-craft-600 mt-1">Dashboard untuk memantau performa usaha</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
