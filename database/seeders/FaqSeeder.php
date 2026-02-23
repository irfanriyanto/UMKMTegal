<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara mendaftarkan UMKM saya?',
                'answer' => 'Untuk mendaftarkan UMKM, silakan klik tombol "Daftar" di halaman utama, buat akun, lalu lengkapi profil UMKM Anda melalui dashboard.',
                'category' => 'Pendaftaran',
                'sort_order' => 1,
            ],
            [
                'question' => 'Apakah pendaftaran UMKM berbayar?',
                'answer' => 'Tidak, pendaftaran dan penggunaan platform ini sepenuhnya GRATIS untuk semua pelaku UMKM.',
                'category' => 'Pendaftaran',
                'sort_order' => 2,
            ],
            [
                'question' => 'Bagaimana proses verifikasi UMKM?',
                'answer' => 'Setelah Anda melengkapi profil UMKM, tim kami akan melakukan verifikasi dalam 1-3 hari kerja. Anda akan mendapat notifikasi setelah proses selesai.',
                'category' => 'Verifikasi',
                'sort_order' => 3,
            ],
            [
                'question' => 'Bagaimana cara menambahkan produk?',
                'answer' => 'Masuk ke Dashboard UMKM, pilih menu "Produk", lalu klik "Tambah Produk". Isi informasi produk dan upload foto produk Anda.',
                'category' => 'Produk',
                'sort_order' => 4,
            ],
            [
                'question' => 'Apakah ada batasan jumlah produk yang bisa ditambahkan?',
                'answer' => 'Tidak ada batasan jumlah produk. Anda bebas menambahkan sebanyak mungkin produk yang Anda miliki.',
                'category' => 'Produk',
                'sort_order' => 5,
            ],
            [
                'question' => 'Bagaimana pelanggan menghubungi UMKM saya?',
                'answer' => 'Pelanggan dapat melihat informasi kontak yang Anda cantumkan di profil UMKM, termasuk nomor telepon, email, dan link media sosial.',
                'category' => 'Kontak',
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
