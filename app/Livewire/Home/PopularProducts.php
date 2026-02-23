<?php

namespace App\Livewire\Home;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PopularProducts extends Component
{
    public function render()
    {
        $products = Cache::remember('products.popular.8', 1800, function () {
            return Product::query()
                ->with(['umkmProfile', 'images', 'category']) // Eager loading
                ->where('is_available', true)
                ->whereHas('umkmProfile', fn($q) => $q->where('is_verified', true))
                ->withCount('productViews')
                ->orderByDesc('product_views_count')
                ->limit(8)
                ->get();
        });

        return view('livewire.home.popular-products', [
            'products' => $products,
        ]);
    }
}
