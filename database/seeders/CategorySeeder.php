<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan & Minuman', 'icon' => '🍽️', 'sort_order' => 1],
            ['name' => 'Kerajinan Tangan', 'icon' => '🎨', 'sort_order' => 2],
            ['name' => 'Fashion & Aksesoris', 'icon' => '👗', 'sort_order' => 3],
            ['name' => 'Batik & Tenun', 'icon' => '🧵', 'sort_order' => 4],
            ['name' => 'Furniture & Dekorasi', 'icon' => '🪑', 'sort_order' => 5],
            ['name' => 'Pertanian & Perkebunan', 'icon' => '🌾', 'sort_order' => 6],
            ['name' => 'Kesehatan & Kecantikan', 'icon' => '💄', 'sort_order' => 7],
            ['name' => 'Elektronik & Gadget', 'icon' => '📱', 'sort_order' => 8],
            ['name' => 'Jasa & Layanan', 'icon' => '🛠️', 'sort_order' => 9],
            ['name' => 'Lainnya', 'icon' => '📦', 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
